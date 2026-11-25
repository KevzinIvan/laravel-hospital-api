import { ref } from 'vue'
import './Login.css'

const API = 'http://127.0.0.1:8000/api'

export default {
  emits: ['login'],
  setup(props, { emit }) {
    const username = ref('')
    const password = ref('')

    async function login() {
      try {
        const res = await fetch(API + '/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            username: username.value,
            password: password.value
          })
        })

        const json = await res.json()

        if (!res.ok) {
          alert(json.error || 'Login gagal')
          return
        }

        emit('login', json.token)
      } catch {
        alert('Server tidak terhubung')
      }
    }

    return {
      username,
      password,
      login
    }
  }
}
