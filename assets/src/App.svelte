<script>
  import Carousel from "svelte-carousel";
  import Review from "./Review.svelte";
  import Stars from "./Stars.svelte";

  export let data;
  export let proxy_url;

  let container;

  let innerWidth = 0;
  $: parentWidth = innerWidth ? container.offsetWidth : 0;
  $: nToShow = Math.min(Math.round(parentWidth / 350), 4);
</script>

<svelte:window bind:innerWidth />

<div class="reviews-container" bind:this={container}>
  <div class="header business-profile">
    <div class="businesss-icon pb-1">
      <img
        src="{proxy_url}?url={data.result.icon}"
        alt="Business Icon of {data.result.name}"
      />
    </div>
    {#if data.result.name}
      <h3>{data.result.name}</h3>
    {/if}
    <div class="business-stars pb-1">
      <Stars rating={data.result.rating} />
    </div>
    {#if data.result.user_ratings_total}
      <p class="pb-1">
        Based on {data.result.user_ratings_total} reviews.
      </p>
    {/if}
    <a class="button btn button-primary btn-primary" href={data.result.url}>
      Review us on Google
    </a>
  </div>
  <Carousel autoplay autoplayDuration={2500} particlesToShow={nToShow}>
    {#each data.result.reviews as r}
      <!-- content here -->
      <Review bind:data={r} bind:proxy_url />
    {:else}
      <div>No reviews available.</div>
    {/each}
  </Carousel>
</div>

<style>
  .reviews-container {
    display: flex;
  }

  .business-profile {
    min-width: 15em;
    text-align: center;
  }

  .pb-1 {
    padding-bottom: 0.5em;
  }
</style>
