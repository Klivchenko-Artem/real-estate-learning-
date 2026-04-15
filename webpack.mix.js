const mix = require("laravel-mix");
const path = require("path");


mix
    .alias({
        "@": path.join(__dirname, "resources/admin/js"),
    })
    // Опции mix'а
    .options({
        terser: {
            extractComments: false,
        },
    })
    // Копируем картинки
    .copyDirectory("resources/admin/images", 'public/assets/admin/images')
    // Прописываем пути
    .setPublicPath("public/assets/admin/")
    .setResourceRoot("../")
    // Сборка js и css для админки
    .js("resources/admin/js/app.js", "/js")
    .sass("resources/admin/scss/app.scss", "/css")
    // Добавляем vendor.js
    .extract()
    // Добавляем хэширование файлов
    .version();
