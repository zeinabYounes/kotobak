import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from "path";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',

            ],
            refresh: true,
        }),
    ],
    resolve: {
      alisas: {
        '~bootstrap':path.resolve(__dirname,'node_modules/bootstrap'),
        // '@':path.resolve(__dirname,'resources/js'),
        // '~':path.resolve(__dirname,'resources/css'),
      },
    },


    build:{

      chunkSizeWarningLimit:1600,
      rollupOptions:{
        output:{
          manualChunks(id){
            if(id.includes('node_modules')){
              return id.toString().split('node_modules')[1].split('/')[0].toString();
            }
          },
        },
      },
    },
});
