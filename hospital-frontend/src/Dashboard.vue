<script src="./Dashboard.js"></script>

<template>
  <div class="dashboard">
    <aside class="sidebar">
      <img class="sidebar-logo" :src="logo" alt="Hospital Management System" />

      <nav aria-label="Navigasi utama">
        <button
          v-for="[key, label] in items"
          :key="key"
          class="nav-link"
          :class="{ active: table === key }"
          :aria-current="table === key ? 'page' : undefined"
          @click="selectTable(key)"
        >{{ label }}</button>
      </nav>
    </aside>

    <main class="main">
      <header class="topbar">
        <div class="breadcrumb">Dashboard {{ table === 'overview' ? '' : `/ ${selected?.[1]}` }}</div>
        <button class="logout" @click="logout">Log out</button>
      </header>

      <section class="content">
        <div class="page-heading">
          <h1>{{ selected?.[1] }}</h1>
          <button class="refresh" :disabled="loading || summaryLoading" @click="handleRefresh">
            {{ (loading || summaryLoading) ? 'Loading...' : 'Refresh' }}
          </button>
        </div>

        <!-- TAMPILAN MENU UTAMA (OVERVIEW) -->
        <div v-if="table === 'overview'">
          <h2 class="welcome">Hi, {{ username || 'User' }}</h2>

          <div class="summary-grid">
            <div
              v-for="[key, label] in summaryItems"
              :key="key"
              class="summary-card"
            >
              <b>{{ label }}</b>
              <span>{{ summaryLoading ? '...' : (summaryCounts[key] ?? 0) }}</span>
            </div>
          </div>
        </div>

        <!-- TAMPILAN TABEL DATA -->
        <section v-else class="data-card">
          <div class="card-heading">
            <div class="card-actions">
              <button class="btn-add">Add</button>
              <button class="btn-edit">Edit</button>
              <button class="btn-delete" @click="isDeleting = !isDeleting">
                {{ isDeleting ? 'Done' : 'Delete' }}
              </button>
              <button class="btn-sort" @click="isSorted = !isSorted">
                {{ isSorted ? 'Reset' : 'Sort A - Z' }}
              </button>
            </div>
            <label>
              <input v-model="search" placeholder="Search by ID..." />
            </label>
          </div>

          <div class="table-wrap">
            <table v-if="columns.length">
              <thead>
                <tr>
                  <th v-for="column in columns" :key="column">{{ column.replaceAll('_', ' ') }}</th>
                  <th v-if="isDeleting" style="width: 60px; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in paddedRows" :key="row?.id ?? `empty-${index}`">
                  <td v-for="column in columns" :key="column">
                    {{ row ? (typeof row[column] === 'object' && row[column] !== null ? JSON.stringify(row[column]) : row[column] ?? '-') : '' }}
                  </td>
                  <td v-if="isDeleting" style="text-align: center;">
                    <button v-if="row" class="btn-remove" @click="removeRow(row.id)">✕</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-else class="no-data">
              <b>{{ loading ? 'Loading data...' : error ? 'Could not load data' : 'No data available' }}</b>
              <p>{{ error || 'Records will appear here when available.' }}</p>
              <button v-if="error" class="try-again" @click="loadData">Try again</button>
            </div>
          </div>
        </section>
      </section>
    </main>
  </div>
</template>
