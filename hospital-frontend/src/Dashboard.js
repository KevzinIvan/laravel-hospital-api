import { computed, onMounted, ref } from 'vue'
import logo from './assets/logo.png'
import './Sidebar.css'
import './Dashboard.css'

const ALL_ITEMS = [
  ['overview', 'Dashboard'],
  ['patient', 'Patients'], ['appointment', 'Appointments'], ['treatments', 'Treatments'],
  ['doctor', 'Doctors'], ['staff', 'Staff'], ['staff_schedules', 'Staff Schedules'],
  ['hospital_beds', 'Hospital Beds'], ['billing', 'Billing'], ['user', 'Users'], ['logs', 'Activity Logs'],
]

const ALLOWED = {
  doctor: ['overview', 'appointment', 'treatments', 'doctor', 'staff'],
  nurse: ['overview', 'patient', 'appointment', 'treatments', 'doctor', 'staff_schedules', 'hospital_beds', 'billing'],
  receptionist: ['overview', 'patient', 'appointment', 'treatments', 'doctor', 'staff_schedules', 'hospital_beds', 'billing'],
}

const SUMMARY_CONFIG = {
  admin: ['patient', 'doctor', 'staff', 'hospital_beds'],
  doctor: ['appointment', 'treatments', 'doctor'],
  nurse: ['patient', 'hospital_beds', 'appointment'],
  receptionist: ['patient', 'appointment', 'billing'],
}

const api = (url, token) => fetch(`http://127.0.0.1:8000/api/${url}`, {
  headers: { Accept: 'application/json', Authorization: `Bearer ${token}` }
}).then(r => r.ok ? r.json() : Promise.reject())

export default {
  props: { token: { type: String, required: true } },
  emits: ['logout'],
  setup(props, { emit }) {
    const role = ref('admin')
    const username = ref('')
    const table = ref('overview')
    const rows = ref([])
    const search = ref('')
    const loading = ref(false)
    const error = ref('')
    const isSorted = ref(false)
    const isDeleting = ref(false)
    const summaryCounts = ref({})
    const summaryLoading = ref(false)

    const items = computed(() => ALLOWED[role.value] ? ALL_ITEMS.filter(([k]) => ALLOWED[role.value].includes(k)) : ALL_ITEMS)
    const summaryItems = computed(() => ALL_ITEMS.filter(([k]) => (SUMMARY_CONFIG[role.value] || SUMMARY_CONFIG.admin).includes(k)))
    const selected = computed(() => items.value.find(([k]) => k === table.value))
    const columns = computed(() => rows.value.length ? Object.keys(rows.value[0]) : [])

    function getSortKey(row) {
      if (!row) return ''
      if ('name' in row) return row.name ?? ''
      if ('username' in row) return row.username ?? ''
      if ('patient_name' in row) return row.patient_name ?? ''
      const key = Object.keys(row).find(k => k !== 'id' && !k.endsWith('_at'))
      return key ? row[key] ?? '' : ''
    }

    const displayRows = computed(() => !isSorted.value ? rows.value : [...rows.value].sort((a, b) =>
      String(getSortKey(a)).localeCompare(String(getSortKey(b)), undefined, { numeric: true, sensitivity: 'base' })
    ))

    const visibleRows = computed(() => displayRows.value.filter(r => {
      const q = search.value.trim().toLowerCase()
      return !q || Object.values(r).some(v => String(v ?? '').toLowerCase().includes(q))
    }))
    const paddedRows = computed(() => visibleRows.value.length >= 5 ? visibleRows.value : [...visibleRows.value, ...Array(5 - visibleRows.value.length).fill(null)])

    async function loadSummary() {
      summaryLoading.value = true
      await Promise.all(summaryItems.value.map(([k]) =>
        api(k, props.token)
          .then(r => summaryCounts.value[k] = Array.isArray(r.data) ? r.data.length : (r.data ? 1 : 0))
          .catch(() => summaryCounts.value[k] = 0)
      ))
      summaryLoading.value = false
    }

    async function loadData() {
      if (table.value === 'overview') return loadSummary()
      loading.value = true
      error.value = ''
      try {
        const res = await api(table.value, props.token)
        rows.value = Array.isArray(res.data) ? res.data : (res.data ? [res.data] : [])
      } catch {
        rows.value = []
        error.value = 'Data gagal dimuat.'
      } finally {
        loading.value = false
      }
    }

    function selectTable(key) {
      table.value = key
      search.value = ''
      isSorted.value = false
      isDeleting.value = false
      loadData()
    }

    async function removeRow(id) {
      if (!confirm(`Yakin ingin menghapus data dengan ID ${id}?`)) return
      try {
        const res = await fetch(`http://127.0.0.1:8000/api/${table.value}/${id}`, {
          method: 'DELETE',
          headers: { Accept: 'application/json', Authorization: `Bearer ${props.token}` },
        })
        const json = await res.json()
        if (!res.ok) throw new Error(json.message || json.error || 'Gagal menghapus data')
        loadData()
      } catch (err) {
        alert(err.message || 'Gagal menghapus data.')
      }
    }

    onMounted(() => {
      api('me', props.token).then(u => {
        if (u?.username) username.value = u.username.charAt(0).toUpperCase() + u.username.slice(1)
        if (u?.role) role.value = u.role
      }).catch(() => {}).finally(loadData)
    })

    return {
      logo, role, username, table, rows, search, loading, error, isSorted, isDeleting,
      summaryCounts, summaryLoading, items, summaryItems, selected,
      columns, visibleRows, paddedRows, loadSummary, loadData,
      selectTable, handleRefresh: loadData, logout: () => emit('logout'),
      removeRow,
    }
  },
}
