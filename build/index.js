(()=>{"use strict";const e=window.wp.i18n,i=window.wp.blocks,t=window.React,s=window.wp.components;(0,i.registerBlockVariation)("core/embed",{name:"wistia",title:"Wistia Embed",description:(0,e.__)("Embed a Wistia video.","wistia-embed-block"),icon:{src:()=>(0,t.createElement)(s.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 34.4 26.78"},(0,t.createElement)(s.G,null,(0,t.createElement)(s.Path,{fill:"#2949e5",strokeWidth:"0",d:"M16.09 17.1h-5.2c-1.58 0-3.08.68-4.11 1.87L.21 26.53c4.78.25 9.78.25 13.3.25 18.31 0 20.89-11.27 20.89-16.55-1.59 1.93-6.06 6.87-18.32 6.87ZM32.14 0c-.08.92-.59 4.69-11.31 4.69-8.72 0-12.24 0-20.83-.17l6.44 7.4a6.66 6.66 0 0 0 4.96 2.3c2.13.03 5.05.06 5.53.06 11.01 0 17.19-5.05 17.19-9.89 0-2.01-.67-3.44-1.97-4.4Z"})))},patterns:[/https?:\/\/[^.]+\.(wistia\.com|wi\.st)\/(medias|embed)\/.*/],attributes:{providerNameSlug:"wistia",responsive:!0,type:"video"},isActive:e=>"wistia"===e.providerNameSlug})})();