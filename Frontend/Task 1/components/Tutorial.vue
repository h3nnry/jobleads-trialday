<!-- Please remove this file from your project -->
<template>
  <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg p-6">
        <h2 class="text-2xl leading-7 font-semibold" style="font-family: Croissant One">
          Welcome to your Poorly optimized Nuxt Application
        </h2>
        <p class="mt-3 text-gray-600">
          Optimize me in terms of web performance and Core Web Vitals. <br />
          Your task is to identify my issues and implement optimization solutions for me to improve the web page's performance and Core Web Vitals scores. <br />

          <ul>
            <li># Core Web Vitals Focus: Pay special attention to optimizing for: LCP, FID, CLS</li>
            <li># Optimization Strategies: Some areas you might consider (but not limited to): 
              <ul>
                <li>- Minify CSS, JS, and HTML files.</li>
                <li>- Optimize images (format, compression, lazy loading).</li>
                <li>- Largest Contentful Paint (LCP): Improve loading performance.</li>
                <li>- First Input Delay (FID): Optimize interactivity.</li>
                <li>- Cumulative Layout Shift (CLS): Ensure visual stability.</li>
              </ul>    
            </li>
            <li># Implement caching strategies.</li>
            <li># Review and optimize web fonts.</li>
            <li># Use efficient CSS and JS delivery methods.</li>
            <li># Reduce server response times.</li>
          </ul>
        </p>
        <p class="mt-4 pt-4 text-gray-800 border-t border-dashed">
          Documentation: Along with the optimized web page, provide a comprehensive report on:
          <ul>
            <li>- The issues you identified.</li>
            <li>- The steps taken to rectify each issue.</li>
            <li>- Before and after performance scores.</li>
          </ul>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NuxtTutorial'
}
</script>
