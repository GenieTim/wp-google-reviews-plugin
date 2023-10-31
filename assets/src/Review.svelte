<script>
  import Stars from "./Stars.svelte";

  export let data;
  export let proxy_url;
</script>

<div class="review-container">
  <div class="author-container">
    <div class="author-image">
      <img
        src="{proxy_url}?url={data.profile_photo_url}"
        alt="Profile Photo of {data.author_name}"
        width="100"
      />
    </div>
    <div class="author-name">
      {data.author_name}
    </div>
    <div class="author-date">
      <a
        href={data.author_url}
        title="View Review on Google"
        class="review-wrapper-link"
        target="_blank"
      >
        {data.relative_time_description}
      </a>
    </div>
  </div>
  <div class="review-text">
    <p>
      {data.text}
    </p>
  </div>
  <div class="stars-container">
    <Stars rating={data.rating} />
  </div>
</div>

<style>
  .review-container {
    padding: 0.75em;
    margin: .5em;
    /* margin-left: 1em; */
    /* border: 1px solid var(--review-container-border-color, rgba(0, 0, 0, 0.25)); */
    border-radius: 4px;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.24);
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: min-content min-content 1fr;
    gap: 0px 0px;
    grid-template-areas:
      "author"
      "stars"
      "text";
  }

  .review-wrapper-link:hover {
    text-decoration: none;
  }

  .author-container {
    grid-area: author;
    word-wrap: normal;
    display: grid;
    grid-template-columns: min-content 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 0px 1em;
    grid-template-areas:
      "authoricon authorname"
      "authoricon authordate";
  }

  .author-date {
    grid-area: authordate;
  }

  .author-name {
    grid-area: authorname;
  }

  .author-image {
    grid-area: authoricon;
    max-width: 5em;
    min-width: 3em;
    gap: 0 1em;
  }

  .stars-container {
    grid-area: stars;
  }

  .review-text {
    grid-area: text;
    font-size: 0.85em;
    max-height: 17.5em;
    overflow-y: auto;
  }

  .review-text p {
    margin: 0;
    padding: 0;
  }
</style>
