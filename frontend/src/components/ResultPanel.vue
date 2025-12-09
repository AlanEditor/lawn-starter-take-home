<template>
  <section class="results-panel">
    <header class="results-panel__header">
      <h2 class="results-panel__title">Results</h2>
      <span class="results-panel__divider"></span>
    </header>

    <div class="results-panel__body">
      <p v-if="loading" class="results-panel__placeholder">Searching…</p>

      <p v-else-if="!results.length" class="results-panel__placeholder">
        There are zero matches.<br />
        Use the form to search for People or Movies.
      </p>

      <ul v-else class="results-list">
        <li
            v-for="item in results"
            :key="item.url ?? item.name ?? item.title"
            class="results-list__row"
        >
          <span class="results-list__name">
            {{ item.name ?? item.title }}
          </span>

          <button
              class="results-list__cta"
              type="button"
              @click="handleSeeDetails(item)"
          >
            See Details
          </button>
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { toRefs } from 'vue';

const emit = defineEmits(["result:details"]);

function handleSeeDetails(item) {
  emit("result:details", item);
}


const props = defineProps({
  results: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
  kind: {
    type: String,
    default: 'people',
  },
});

const { results, loading, kind } = toRefs(props);
</script>

<style scoped>
.results-panel {
  width: clamp(360px, 54vw, 560px);
  min-height: clamp(340px, 58vw, 540px);
  padding: 24px;
  border-radius: 8px;
  border: 0.5px solid #0ab463;
  background-color: #ffffff;
  box-shadow: 0 0.5px 1px rgba(0, 0, 0, 0.12);
  display: flex;
  flex-direction: column;
}

.results-panel__header {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.results-panel__title {
  margin: 0;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: #000000;
}

.results-panel__divider {
  width: 100%;
  height: 1px;
  background-color: #cfcfcf;
  margin-bottom: 5px;
}

.results-panel__body {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.results-panel__placeholder {
  margin: auto;
  text-align: center;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  color: #b5b5b5;
}

.results-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0;
}

.results-list__row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 18px 0;
  border-bottom: 1px solid #d9d9d9;
}

.results-list__row:first-of-type {
  padding-top: 8px;
}

.results-list__name {
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: #222222;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.results-list__cta {
  padding: 10px 20px;
  border-radius: 999px;
  border: none;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.08em;
  color: #ffffff;
  text-transform: uppercase;
  background-color: #09b563;
  cursor: pointer;
  transition: filter 0.2s ease, transform 0.2s ease;
  margin-top: 5px;
}

.results-list__cta:hover,
.results-list__cta:focus-visible {
  filter: brightness(1.08);
}

.results-list__cta:focus-visible {
  outline: 2px solid rgba(9, 181, 99, 0.35);
  outline-offset: 2px;
}

@media (max-width: 768px) {
  .results-panel {
    width: 100%;
    min-height: 360px;
    padding: 20px 18px;
  }

  .results-list__row {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }

  .results-list__cta {
    align-self: flex-start;
  }
}
</style>