<script>
  export let rating;
</script>

<div class="stars rating-{rating}" alt="{rating}-star rating">
  {#each { length: rating } as _, i}
    ★
  {/each}
  {#each { length: 5 - rating } as _, i}
    ☆
  {/each}
</div>

<style>
  .stars {
    font-size: 1.5em;
    word-break: keep-all;
    color: #fb8e28;
  }
</style>
