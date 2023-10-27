import App from "./App.svelte";

let targets = document.getElementsByTagName("wp-google-reviews");

for (let i = 0; i < targets.length; i++) {
  let target = targets[i];
  const app = new App({
    target: target,
    props: {
        data: JSON.parse(target.getAttribute('data-reviews')),
        proxy_url: target.getAttribute('data-proxy-url')
    }
  });
}

export default app;
