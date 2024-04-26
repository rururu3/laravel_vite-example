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
<!-- 略 -->>
<head>
  <!-- 略 -->>
  @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Vueを読み込む -->
</head>
<body>
  <!-- 略 -->>
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

# Quasarを使う
[Quasar Vite Plugin](https://quasar.dev/start/vite-plugin)
1. Quasarを追加
```bash
npm install --save quasar @quasar/extras
npm install --save-dev @quasar/vite-plugin sass@^1.33.0
```

2. Quasarを読み込む
- app.jsにQuasarを使う設定を追加
```JavaScript
import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import { Quasar } from 'quasar'

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

import App from './components/App.vue';

const myApp = createApp(App);

myApp.use(Quasar, {
  plugins: {}, // import Quasar plugins and add here
});

myApp.mount("#app");
```

3. Viteの設定ファイルを更新:
- vite.config.jsにQuasarを使う設定を追加
```JavaScript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'

export default defineConfig({
  plugins: [
    vue({
      template: { transformAssetUrls }
    }),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    quasar({
      sassVariables: 'resources/js/quasar-variables.sass'
    })
  ],
});
```

4. sassファイルを追加
- resources/js/quasar-variables.sassを下記内容で追加する
```sass
$primary   : #1976D2
$secondary : #26A69A
$accent    : #9C27B0

$dark      : #1D1D1D

$positive  : #21BA45
$negative  : #C10015
$info      : #31CCEC
$warning   : #F2C037
```

5. Vueコンポーネントを編集:
- resources/js/App.vueファイルにQuasarコンポーネントを追加する
```JavaScript
<template>
  <div>
    <p>{{ counter }}</p>
    <button @click="counter += 1">Click!</button>

    <div class="q-pa-md q-gutter-sm">
      <q-btn push color="white" text-color="primary" label="Unread Mails">
        <q-badge color="orange" floating>22</q-badge>
      </q-btn>

      <q-btn dense color="purple" round icon="email" class="q-ml-md">
        <q-badge color="red" floating>4</q-badge>
      </q-btn>
    </div>
  </div>
</template>

<script setup>
  const counter = defineModel({ default: 0 });
</script>
```

# Laravel Reverb
[reverb](https://laravel.com/docs/11.x/reverb)

[参考](https://reffect.co.jp/laravel/laravel-reverb)

1. Broadcasting機能をインストールする(Laravel Reverbのインストール)
- コマンドを利用してインストールする
```bash
php artisan install:broadcasting
```
※途中でLaravel ReverbやNodeモジュールのインストールするかなど聞かれるのでYesで

2. テストのためのイベント作成
- 動作確認のためテストイベントを作成
```bash
php artisan make:event TestEvent
```

3. イベントクラスを修正
- ShouldBroadcastインターフェイスを使うのとChannelクラスを使用するように修正する
```php
// 略
class TestEvent implements ShouldBroadcast
{
  // 略
        return [
            new Channel('test-channel'),
        ];
}
```
4. イベント実行をする
- テストのため/にアクセスした際にイベントを発行するようにする
web.php
```php
<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    TestEvent::dispatch();
    return view('welcome');
});
```

5. Reverbサーバー起動
- 
```bash
php artisan reverb:start
```

6. 確認
- サーバーを起動して/にアクセスしイベントが発行されてるか確認する
```bash
php artisan serve
```
※database/database.sqliteのjobsテーブルにデータが追加されてたらOK

7. Queue Workerの起動
- Job実行のためにQueue Workerを起動する
```bash
php artisan queue:work
```

8. ブラウザ側でのデータ受信準備
- 発行されたイベントを受け取るために処理を追加する(Viteの設定はしてるものとする)
bootstrap.js
```JavaScript
// 略
Echo.channel("test-channel").listen("TestEvent", function (e) {
    console.log("received a message");
});
```
※`npm run dev`でVite開発サーバーを起動しておくこと
※`php artisan reverb:start --debug`でReverbサーバーをデバッグ有効で起動するとコンソールにログが流れてくる

9. イベント発行時に情報をいれる
- イベントにメッセージを登録できるようにする
TestEvent.php
```php
// 略
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
        $this->message = 'Hello World';
    }
```
bootstrap.js
```JavaScript
// 略
    console.log("received a message", e.message);
```
※イベント修正したら`php artisan queue:work`でQueue Workerの再起動が必要かも

10. Vueでイベントを受け取れるように
- vueコンポーネントでイベント登録してデータ取得できるようにする
App.vue
```HTML
<!-- 略 -->
  window.Echo.channel("test-channel").listen("TestEvent", function (e) {
      console.log("vue: ", e.message);
  });
```