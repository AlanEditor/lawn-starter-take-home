<template>
  <header class="header">
    <div class="header__inner">
      <h1>SWStarter</h1>
    </div>
  </header>
</template>

<style scoped>
.header {
  width: 100%;
  background-color: #ffffff;
  box-shadow: 0 1px 0 0 #0ab463;
}

.header__inner {
  width: min(100%, 720px);
  margin: 0 auto 15px;
  padding-block: 7px;
  padding-inline: clamp(16px, 6vw, 60px);
  display: flex;
  justify-content: center;
  align-items: center;
}

.header__inner h1 {
  margin: 0;
  color: #0ab463;
  font-size: clamp(1rem, 3vw, 1.3rem);
  letter-spacing: clamp(0.03em, 0.4vw, 0.05em);
  text-align: center;
}
</style>