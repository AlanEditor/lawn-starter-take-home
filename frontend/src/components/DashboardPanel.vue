<template>
  <div class="dashboard">
    <SearchPanel
        v-if="!openDetailsModal"
        @search:results="handleResults"
        @search:loading="loading = $event"
        @search:error="handleError"
    />

    <ResultPanel
        v-if="!openDetailsModal"
        :results="results"
        :loading="loading"
        :kind="kind"
        @result:details="showDetailsModal"
    />

    <DetailsPanel
        v-else
        :kind="selectedKind"
        :item="selectedItem"
        :related="related"
        :loading="detailLoading"
        @navigate="handleNavigateFromDetails"
        @back="handleCloseDetailsModal"
    />
  </div>

  <p v-if="error" class="feedback-error">{{ error }}</p>
</template>

<script setup>
import {ref} from 'vue';
import SearchPanel from '@/components/SearchPanel.vue';
import ResultPanel from '@/components/ResultPanel.vue';
import DetailsPanel from '@/components/DetailsPanel.vue';

const BASE_URL = import.meta.env.VITE_SWAPI_BASE_URL ?? 'http://api.swapi.io:8080/api/swapi';

const kind = ref('people');
const results = ref([]);
const loading = ref(false);
const error = ref('');

const openDetailsModal = ref(false);
const selectedItem = ref(null);
const selectedKind = ref('people');
const related = ref([]);
const detailLoading = ref(false);

const handleResults = ({ kind: emittedKind, results: emittedResults }) => {
  kind.value = emittedKind;
  results.value = emittedResults;
};

const handleError = (message) => {
  error.value = message;
};

const extractSwapiPath = (url) => {
  try {
    const { pathname } = new URL(url);
    return pathname.replace(/^\/api\//, '').replace(/\/$/, '');
  } catch {
    return url;
  }
};

const fetchResource = async (url) => {
  const path = extractSwapiPath(url);
  const endpoint = url.startsWith('http')
      ? url
      : `${BASE_URL}/${path}`;

  const response = await fetch(endpoint);
  if (!response.ok) {
    throw new Error(`Erro ao buscar ${path}`);
  }
  return response.json();
};

const loadRelated = async (currentKind, item) => {
  const urls = currentKind === 'people' ? item.films ?? [] : item.characters ?? [];
  const targetKind = currentKind === 'people' ? 'movies' : 'people';

  if (!urls.length) {
    related.value = [];
    return;
  }

  detailLoading.value = true;

  try {
    related.value = await Promise.all(
        urls.map(async (resourceUrl) => {
          try {
            const data = await fetchResource(resourceUrl);
            return {
              url: resourceUrl,
              name: data.name ?? data.title ?? 'Unknown',
              kind: targetKind,
            };
          } catch {
            return {url: resourceUrl, name: 'Unavailable', kind: targetKind};
          }
        })
    );
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Erro ao carregar relacionados.';
    related.value = [];
  } finally {
    detailLoading.value = false;
  }
};

const showDetailsModal = async (item) => {
  selectedItem.value = item;
  selectedKind.value = kind.value;
  openDetailsModal.value = true;
  await loadRelated(selectedKind.value, item);
};

const handleNavigateFromDetails = async ({ url, kind: nextKind }) => {
  detailLoading.value = true;
  error.value = '';

  try {
    const nextItem = await fetchResource(url);
    selectedKind.value = nextKind;
    selectedItem.value = nextItem;
    await loadRelated(nextKind, nextItem);
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Erro ao navegar.';
  } finally {
    detailLoading.value = false;
  }
};

const handleCloseDetailsModal = () => {
  openDetailsModal.value = false;
  selectedItem.value = null;
  related.value = [];
};
</script>

<style scoped>
.dashboard {
  width: min(100%, 900px);
  margin: 40px 0 40px 204px;
  display: grid;
  grid-template-columns: clamp(320px, 46vw, 420px) 1fr;
  gap: 40px;
  align-items: start;
}

@media (max-width: 768px) {
  .dashboard {
    grid-template-columns: 1fr;
    margin: 24px 16px;
  }
}

.feedback-error {
  margin: 24px auto 0;
  width: min(100%, 900px);
  padding: 12px 16px;
  border-radius: 6px;
  background-color: rgba(229, 72, 77, 0.12);
  color: #b22222;
  font-family: 'Montserrat', system-ui, sans-serif;
}
</style>