<template>
  <form class="search-panel" @submit.prevent="onSubmit">
    <h2 class="search-panel__title">What are you searching for?</h2>

    <fieldset class="search-panel__options">
      <label class="search-panel__option">
        <input
            class="search-panel__radio"
            type="radio"
            name="kind"
            value="people"
            v-model="kind"
        />
        <span class="search-panel__bullet" aria-hidden="true"></span>
        <span class="search-panel__label">People</span>
      </label>

      <label class="search-panel__option">
        <input
            class="search-panel__radio"
            type="radio"
            name="kind"
            value="movies"
            v-model="kind"
        />
        <span class="search-panel__bullet" aria-hidden="true"></span>
        <span class="search-panel__label">Movies</span>
      </label>
    </fieldset>

    <div class="search-panel__field">
      <input
          v-model.trim="query"
          type="text"
          placeholder="e.g. Chewbacca, Yoda, Boba Fett"
      />
    </div>

    <button
        class="search-panel__submit"
        type="submit"
        :disabled="loading || !query.trim()"
    >
      {{ loading ? 'SEARCHING…' : 'SEARCH' }}
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

const emit = defineEmits(['search:results', 'search:loading', 'search:error']);

const kind = ref('people');
const query = ref('');
const loading = ref(false);
const results = ref([]);

const BASE_URL =
    import.meta.env.VITE_SWAPI_BASE_URL ?? 'http://api.swapi.io:8080/api/swapi';

const onSubmit = async () => {
  const trimmed = query.value.trim();
  if (!trimmed) return;

  loading.value = true;
  emit('search:loading', true);
  emit('search:error', '');
  results.value = [];

  try {
    const url = `${BASE_URL}/${encodeURIComponent(kind.value)}/?search=${encodeURIComponent(trimmed)}`;
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`SWAPI respondeu ${response.status}`);
    }

    const payload = await response.json();
    results.value = Array.isArray(payload) ? payload : payload.results ?? [];

    emit('search:results', {
      kind: kind.value,
      query: trimmed,
      results: results.value,
    });
  } catch (err) {
    const message = err instanceof Error ? err.message : 'Erro inesperado';
    emit('search:error', message);
  } finally {
    loading.value = false;
    emit('search:loading', false);
  }
};
</script>

<style scoped>
.search-panel {
  width: clamp(320px, 46vw, 420px);
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 0.5px 1px rgba(0, 0, 0, 0.12);
  border: 0.5px solid #0ab463;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.search-panel__title {
  margin: 0;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: clamp(0.75rem, 1.6vw, 1rem);
  font-weight: 600;
  line-height: 1.35;
  color: #383838;
}

.search-panel__options {
  margin: 0;
  padding: 0;
  border: none;
  display: flex;
  gap: 18px;
}

.search-panel__option {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  cursor: pointer;
  font-family: 'Montserrat', system-ui, sans-serif;
}

.search-panel__radio {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.search-panel__bullet {
  width: 14px;
  height: 14px;
  border-radius: 50%;
  box-sizing: border-box;
  padding: 3px;
  border: 1px solid #5f5f5f;
  background-color: transparent;
  display: grid;
  place-items: center;
  transition: border-color 0.2s ease, background-color 0.2s ease;
}

.search-panel__bullet::after {
  content: '';
  width: 70%;
  height: 70%;
  border-radius: 50%;
  background-color: transparent;
  transition: background-color 0.2s ease, transform 0.2s ease;
}

.search-panel__radio:checked + .search-panel__bullet {
  border-color: #2d8cff;
  background-color: #2d8cff;
}

.search-panel__radio:checked + .search-panel__bullet::after {
  background-color: #ffffff;
  transform: scale(0.9);
}

.search-panel__radio:focus-visible + .search-panel__bullet {
  outline: 2px solid rgba(10, 180, 99, 0.35);
  outline-offset: 2px;
}

.search-panel__label {
  font-size: clamp(0.75rem, 1.4vw, 0.95rem);
  font-weight: 700;
  color: #000000;
  line-height: 1.35;
}

.search-panel__field input {
  width: 100%;
  height: 44px;
  border-radius: 10px;
  padding: 0 16px;
  border: 1px solid #d3d3d3;
  font-size: clamp(0.8rem, 1.6vw, 1.05rem);
  font-weight: 600;
  letter-spacing: 0.01em;
  color: #4a4a4a;
  background: linear-gradient(180deg, #ffffff 0%, #f7f7f7 100%);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  box-sizing: border-box;
}

.search-panel__field input::placeholder {
  color: #bcbcbc;
  font-weight: 600;
}

.search-panel__field input:focus {
  outline: none;
  border-color: #0ab463;
  box-shadow:
      inset 0 1px 2px rgba(0, 0, 0, 0.14),
      0 0 0 2px rgba(10, 180, 99, 0.18);
}

.search-panel__submit {
  width: 100%;
  height: 50px;
  border-radius: 25px;
  border: none;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: clamp(0.8rem, 1.4vw, 1.05rem);
  font-weight: 700;
  color: #ffffff;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: filter 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
  background-color: #09b563;
}

.search-panel__submit:hover:not(:disabled),
.search-panel__submit:focus-visible:not(:disabled) {
  filter: brightness(1.08);
  transform: translateY(-1px);
}

.search-panel__submit:disabled {
  background-color: #c4c4c4;
  color: #ffffff;
  cursor: not-allowed;
  filter: none;
  transform: none;
}

@media (max-width: 480px) {
  .search-panel {
    width: 100%;
    padding: 18px;
  }
}
</style>