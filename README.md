# Laravel 10でVue 3を使う方法
1. プロジェクトの作成:
- Laravel 10プロジェクトを作成します。
```bash
composer create-project laravel/laravel laravel_vite-example
```

2. Viteの設定:
- プロジェクトのルートディレクトリに移動し、ViteのプラグインであるVue 3をインストールします。
```bash
cd laravel_vite-example
npm install @vitejs/plugin-vue --save-dev
```

3. Viteの設定ファイルを更新:
- vite.config.jsファイルにVueを利用するための追加設定を行います。

```JavaScript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
```

4. Vueを読み込む:
- resources/js/app.jsファイルでVueを追加して読み込みます。
```JavaScript
import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import App from './components/App.vue';

createApp(App).mount("#app");
```

5. Vueコンポーネントを作成:
- resources/js/App.vueファイルにVueコンポーネントを作成します。
```html
<template>
  <div>
    <p>{{ counter }}</p>
    <button @click="counter += 1">Click!</button>
  </div>
</template>

<script setup>
  const counter = defineModel({ default: 0 });
</script>
```

6. HTMLファイルを更新:
- welcome.blade.phpファイルでVueを読み込むための設定を行います。
```html
...
<head>
  ...
  @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Vueを読み込む -->
</head>
<body>
  ...
  <div id="app"></div> <!-- マウントポイント -->
</body>
</html>
```

7. ビルドと実行:
- 以下のコマンドを実行して、プロジェクトをビルドし、サーバーを起動します。
```bash
npm run dev
php artisan serve
```