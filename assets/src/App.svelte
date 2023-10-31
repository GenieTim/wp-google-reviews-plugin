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
    <a
      class="button btn button-primary btn-primary btn-review-us"
      href={data.result.url}
    >
      <div class="g-logo-prev-wrapper">
        Review us on <!-- Google -->
      </div>
      <div class="g-logo-wrapper">
        <svg viewBox="0 0 512 512" height="18" width="18"
          ><g fill="none" fill-rule="evenodd"
            ><path
              d="M482.56 261.36c0-16.73-1.5-32.83-4.29-48.27H256v91.29h127.01c-5.47 29.5-22.1 54.49-47.09 71.23v59.21h76.27c44.63-41.09 70.37-101.59 70.37-173.46z"
              fill="#4285f4"
            /><path
              d="M256 492c63.72 0 117.14-21.13 156.19-57.18l-76.27-59.21c-21.13 14.16-48.17 22.53-79.92 22.53-61.47 0-113.49-41.51-132.05-97.3H45.1v61.15c38.83 77.13 118.64 130.01 210.9 130.01z"
              fill="#34a853"
            /><path
              d="M123.95 300.84c-4.72-14.16-7.4-29.29-7.4-44.84s2.68-30.68 7.4-44.84V150.01H45.1C29.12 181.87 20 217.92 20 256c0 38.08 9.12 74.13 25.1 105.99l78.85-61.15z"
              fill="#fbbc05"
            /><path
              d="M256 113.86c34.65 0 65.76 11.91 90.22 35.29l67.69-67.69C373.03 43.39 319.61 20 256 20c-92.25 0-172.07 52.89-210.9 130.01l78.85 61.15c18.56-55.78 70.59-97.3 132.05-97.3z"
              fill="#ea4335"
            /><path d="M20 20h472v472H20V20z" /></g
          >
        </svg>
      </div>
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

  .g-logo-prev-wrapper {
    display: inline-block;
  }

  .g-logo-wrapper {
    background-color: white;
    border-radius: 50%;
    display: inline-block;
    height: 25px;
    width: 25px;
    text-align: center;
    margin-bottom: calc((25px - 2em) / 2);
    position: relative;
  }

  .g-logo-wrapper > svg {
    height: 18px;
    width: 18px;
    position: absolute;
    margin: 3.5px;
    margin-top: 3px;
    left: 0;
    top: 0;
    /* margin-bottom: calc((25px - 2em) / 2); */
  }

  .g-logo-prev-wrapper {
    line-height: 25px;
    margin-right: 1em;
  }

  .btn-review-us {
    display: inline-block;
    vertical-align: baseline;
  }
</style>
