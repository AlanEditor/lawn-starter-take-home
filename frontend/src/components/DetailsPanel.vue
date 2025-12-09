<template>
  <section class="details-panel">
    <header class="details-panel__header">
      <h1 class="details-panel__title">
        {{ kind === 'people' ? item?.name : item?.title }}
      </h1>
    </header>

    <div class="details-panel__content">
      <article class="details-panel__column">
        <h2 class="details-panel__subtitle">
          {{ kind === 'people' ? 'Details' : 'Opening Crawl' }}
        </h2>
        <span class="details-panel__divider"></span>

        <template v-if="kind === 'people'">
          <dl class="details-panel__list">
            <div><dt>Birth Year</dt><dd>{{ item?.birth_year ?? '—' }}</dd></div>
            <div><dt>Gender</dt><dd>{{ item?.gender ?? '—' }}</dd></div>
            <div><dt>Eye Color</dt><dd>{{ item?.eye_color ?? '—' }}</dd></div>
            <div><dt>Hair Color</dt><dd>{{ item?.hair_color ?? '—' }}</dd></div>
            <div><dt>Height</dt><dd>{{ item?.height ?? '—' }}</dd></div>
            <div><dt>Mass</dt><dd>{{ item?.mass ?? '—' }}</dd></div>
          </dl>
        </template>

        <template v-else>
          <p class="details-panel__paragraph">
            {{ item?.opening_crawl ?? 'No opening crawl available.' }}
          </p>
        </template>
      </article>

      <aside class="details-panel__column">
        <h2 class="details-panel__subtitle">
          {{ kind === 'people' ? 'Movies' : 'Characters' }}
        </h2>
        <span class="details-panel__divider"></span>

        <div class="details-panel__related">
          <p v-if="loading">Loading related data…</p>

          <p v-else-if="!related.length">No related information.</p>

          <ul v-else class="related-list">
            <li v-for="(entry, index) in related" :key="entry.url">
              <button
                  type="button"
                  class="related-list__link"
                  @click="handleNavigate(entry)"
              >
                {{ entry.name }}
              </button>
              <span
                  v-if="index < related.length - 1"
                  class="comma"
                  aria-hidden="true"
              >,</span>
            </li>
          </ul>
        </div>
      </aside>
    </div>

    <button class="details-panel__back" type="button" @click="$emit('back')">
      Back to Search
    </button>
  </section>
</template>

<script setup>
const emit = defineEmits(['back', 'navigate']);

defineProps({
  kind: { type: String, required: true },
  item: { type: Object, required: true },
  related: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false },
});

const handleNavigate = (entry) => {
  emit('navigate', entry);
};
</script>

<style scoped>
.details-panel {
  width: clamp(340px, 80vw, 940px);
  min-height: 480px;
  padding: 32px 36px 48px;
  border-radius: 10px;
  box-shadow: 0 0.5px 1px rgba(0, 0, 0, 0.12);
  border: 0.5px solid #0ab463;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  gap: 32px;
  margin: 40px auto;
}

.details-panel__header {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.details-panel__title {
  margin: 0;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: clamp(1.4rem, 2.8vw, 2rem);
  font-weight: 700;
  color: #000000;
}

.details-panel__content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: clamp(24px, 5vw, 48px);
  flex: 1;
}

.details-panel__subtitle {
  margin: 0;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: clamp(1.1rem, 2.2vw, 1.4rem);
  font-weight: 700;
  color: #111111;
}

.details-panel__divider {
  display: block;
  margin: 5px 0 10px;
  width: 100%;
  height: 1px;
  background-color: #cfcfcf;
}

.details-panel__list {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.details-panel__list div {
  display: inline-flex;
  align-items: baseline;
  gap: 6px;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 1rem;
  color: #000000;
}

.details-panel__list dt {
  margin: 0;
  font-weight: 300;
}

.details-panel__list dt::after {
  content: ':';
}

.details-panel__list dd {
  margin: 0;
  font-weight: 300;
}

.details-panel__paragraph {
  margin: 0;
  white-space: pre-line;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 1rem;
  line-height: 1.6;
  color: #333333;
}

.related-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-wrap: wrap;
  gap: 2px 6px;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 1rem;
}

.related-list li {
  display: inline-flex;
  align-items: center;
}

.related-list__link {
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  color: #2d8cff;
  font: inherit;
  text-decoration: underline;
}

.related-list__link:hover,
.related-list__link:focus-visible {
  text-decoration: none;
}

.comma {
  color: #2d8cff;
}

.details-panel__back {
  align-self: flex-start;
  padding: 12px 36px;
  border-radius: 999px;
  border: none;
  background-color: #09b563;
  color: #ffffff;
  font-family: 'Montserrat', system-ui, sans-serif;
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  cursor: pointer;
  transition: filter 0.2s ease, transform 0.2s ease;
}

.details-panel__back:hover,
.details-panel__back:focus-visible {
  filter: brightness(1.08);
  transform: translateY(-1px);
}

@media (max-width: 640px) {
  .details-panel {
    padding: 24px;
    margin: 24px 16px;
  }
}
</style>