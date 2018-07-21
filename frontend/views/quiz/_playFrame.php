<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 10/5/2017
 * Time: 3:11 PM
 */

use \yii\helpers\Url;

$loadingIcons = [
    // Flask
    '<svg class="lds-flask" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><defs>
<clipPath id="lds-flask-cpid-72eef79003011" clipPathUnits="userSpaceOnUse">
<rect x="0" y="50" width="100" height="50"></rect>
</clipPath>
<pattern id="lds-flask-patid-704df534f7921" patternUnits="userSpaceOnUse" x="0" y="0" width="100" height="100">
<rect x="0" y="0" width="100" height="100" fill="#88a2ce"></rect><circle cx="66" cy="0" r="3" fill="#456caa" transform="translate(0 -26.3667)">
<animateTransform attributeName="transform" type="translate" values="0 129;0 -29" keyTimes="0;1" dur="3s" begin="-1.95s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="30" cy="0" r="3" fill="#456caa" transform="translate(0 37.08)">
<animateTransform attributeName="transform" type="translate" values="0 152;0 -52" keyTimes="0;1" dur="3s" begin="-0.69s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="21" cy="0" r="2" fill="#456caa" transform="translate(0 42.5467)">
<animateTransform attributeName="transform" type="translate" values="0 136;0 -36" keyTimes="0;1" dur="3s" begin="-0.63s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="49" cy="0" r="3" fill="#456caa" transform="translate(0 57.0667)">
<animateTransform attributeName="transform" type="translate" values="0 103;0 -3" keyTimes="0;1" dur="3s" begin="-0.3s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="85" cy="0" r="3" fill="#456caa" transform="translate(0 30.7733)">
<animateTransform attributeName="transform" type="translate" values="0 153;0 -53" keyTimes="0;1" dur="3s" begin="-0.78s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="51" cy="0" r="2" fill="#456caa" transform="translate(0 29.5267)">
<animateTransform attributeName="transform" type="translate" values="0 133;0 -33" keyTimes="0;1" dur="3s" begin="-0.87s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="0" cy="0" r="3" fill="#456caa" transform="translate(0 -10.5667)">
<animateTransform attributeName="transform" type="translate" values="0 129;0 -29" keyTimes="0;1" dur="3s" begin="-1.65s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="76" cy="0" r="2" fill="#456caa" transform="translate(0 42.6333)">
<animateTransform attributeName="transform" type="translate" values="0 135;0 -35" keyTimes="0;1" dur="3s" begin="-0.63s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="18" cy="0" r="3" fill="#456caa" transform="translate(0 -29.4533)">
<animateTransform attributeName="transform" type="translate" values="0 151;0 -51" keyTimes="0;1" dur="3s" begin="-1.68s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="13" cy="0" r="2" fill="#456caa" transform="translate(0 -9.05334)">
<animateTransform attributeName="transform" type="translate" values="0 136;0 -36" keyTimes="0;1" dur="3s" begin="-1.53s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="89" cy="0" r="3" fill="#456caa" transform="translate(0 -8.69334)">
<animateTransform attributeName="transform" type="translate" values="0 112;0 -12" keyTimes="0;1" dur="3s" begin="-1.92s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="16" cy="0" r="2" fill="#456caa" transform="translate(0 33)">
<animateTransform attributeName="transform" type="translate" values="0 152;0 -52" keyTimes="0;1" dur="3s" begin="-0.75s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="77" cy="0" r="3" fill="#456caa" transform="translate(0 -27.14)">
<animateTransform attributeName="transform" type="translate" values="0 137;0 -37" keyTimes="0;1" dur="3s" begin="-1.83s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="55" cy="0" r="3" fill="#456caa" transform="translate(0 47.3067)">
<animateTransform attributeName="transform" type="translate" values="0 151;0 -51" keyTimes="0;1" dur="3s" begin="-0.54s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="9" cy="0" r="2" fill="#456caa" transform="translate(0 15.5467)">
<animateTransform attributeName="transform" type="translate" values="0 118;0 -18" keyTimes="0;1" dur="3s" begin="-1.26s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="73" cy="0" r="3" fill="#456caa" transform="translate(0 -17.2933)">
<animateTransform attributeName="transform" type="translate" values="0 148;0 -48" keyTimes="0;1" dur="3s" begin="-1.53s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="87" cy="0" r="2" fill="#456caa" transform="translate(0 -11.3333)">
<animateTransform attributeName="transform" type="translate" values="0 142;0 -42" keyTimes="0;1" dur="3s" begin="-1.5s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="40" cy="0" r="2" fill="#456caa" transform="translate(0 15.16)">
<animateTransform attributeName="transform" type="translate" values="0 128;0 -28" keyTimes="0;1" dur="3s" begin="-1.17s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="27" cy="0" r="2" fill="#456caa" transform="translate(0 101.147)">
<animateTransform attributeName="transform" type="translate" values="0 106;0 -6" keyTimes="0;1" dur="3s" begin="-2.13s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="79" cy="0" r="3" fill="#456caa" transform="translate(0 -0.293335)">
<animateTransform attributeName="transform" type="translate" values="0 142;0 -42" keyTimes="0;1" dur="3s" begin="-1.32s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="96" cy="0" r="3" fill="#456caa" transform="translate(0 29.76)">
<animateTransform attributeName="transform" type="translate" values="0 116;0 -16" keyTimes="0;1" dur="3s" begin="-0.96s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="28" cy="0" r="3" fill="#456caa" transform="translate(0 52.9)">
<animateTransform attributeName="transform" type="translate" values="0 137;0 -37" keyTimes="0;1" dur="3s" begin="-0.45s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="1" cy="0" r="3" fill="#456caa" transform="translate(0 54.1067)">
<animateTransform attributeName="transform" type="translate" values="0 106;0 -6" keyTimes="0;1" dur="3s" begin="-0.39s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="16" cy="0" r="3" fill="#456caa" transform="translate(0 14.5867)">
<animateTransform attributeName="transform" type="translate" values="0 133;0 -33" keyTimes="0;1" dur="3s" begin="-1.14s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="28" cy="0" r="2" fill="#456caa" transform="translate(0 80.9867)">
<animateTransform attributeName="transform" type="translate" values="0 133;0 -33" keyTimes="0;1" dur="3s" begin="-2.94s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="20" cy="0" r="3" fill="#456caa" transform="translate(0 98.16)">
<animateTransform attributeName="transform" type="translate" values="0 134;0 -34" keyTimes="0;1" dur="3s" begin="-2.64s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="12" cy="0" r="2" fill="#456caa" transform="translate(0 22.7533)">
<animateTransform attributeName="transform" type="translate" values="0 117;0 -17" keyTimes="0;1" dur="3s" begin="-1.11s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="92" cy="0" r="3" fill="#456caa" transform="translate(0 47.1067)">
<animateTransform attributeName="transform" type="translate" values="0 112;0 -12" keyTimes="0;1" dur="3s" begin="-0.57s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="22" cy="0" r="3" fill="#456caa" transform="translate(0 107.64)">
<animateTransform attributeName="transform" type="translate" values="0 116;0 -16" keyTimes="0;1" dur="3s" begin="-2.19s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="34" cy="0" r="3" fill="#456caa" transform="translate(0 -33.3067)">
<animateTransform attributeName="transform" type="translate" values="0 138;0 -38" keyTimes="0;1" dur="3s" begin="-1.92s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="7" cy="0" r="2" fill="#456caa" transform="translate(0 97.4667)">
<animateTransform attributeName="transform" type="translate" values="0 130;0 -30" keyTimes="0;1" dur="3s" begin="-2.61s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="60" cy="0" r="3" fill="#456caa" transform="translate(0 38.4267)">
<animateTransform attributeName="transform" type="translate" values="0 106;0 -6" keyTimes="0;1" dur="3s" begin="-0.81s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="99" cy="0" r="3" fill="#456caa" transform="translate(0 21.2267)">
<animateTransform attributeName="transform" type="translate" values="0 133;0 -33" keyTimes="0;1" dur="3s" begin="-1.02s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="62" cy="0" r="2" fill="#456caa" transform="translate(0 11.8667)">
<animateTransform attributeName="transform" type="translate" values="0 115;0 -15" keyTimes="0;1" dur="3s" begin="-1.38s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="10" cy="0" r="2" fill="#456caa" transform="translate(0 108.96)">
<animateTransform attributeName="transform" type="translate" values="0 116;0 -16" keyTimes="0;1" dur="3s" begin="-2.16s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="95" cy="0" r="2" fill="#456caa" transform="translate(0 -32.1667)">
<animateTransform attributeName="transform" type="translate" values="0 135;0 -35" keyTimes="0;1" dur="3s" begin="-1.95s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="23" cy="0" r="3" fill="#456caa" transform="translate(0 100.5)">
<animateTransform attributeName="transform" type="translate" values="0 125;0 -25" keyTimes="0;1" dur="3s" begin="-2.49s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="55" cy="0" r="2" fill="#456caa" transform="translate(0 83.88)">
<animateTransform attributeName="transform" type="translate" values="0 116;0 -16" keyTimes="0;1" dur="3s" begin="-2.73s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="46" cy="0" r="2" fill="#456caa" transform="translate(0 96.2867)">
<animateTransform attributeName="transform" type="translate" values="0 103;0 -3" keyTimes="0;1" dur="3s" begin="-2.19s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="77" cy="0" r="2" fill="#456caa" transform="translate(0 -15.6133)">
<animateTransform attributeName="transform" type="translate" values="0 124;0 -24" keyTimes="0;1" dur="3s" begin="-1.83s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="13" cy="0" r="3" fill="#456caa" transform="translate(0 68.04)">
<animateTransform attributeName="transform" type="translate" values="0 116;0 -16" keyTimes="0;1" dur="3s" begin="-0.09s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="96" cy="0" r="2" fill="#456caa" transform="translate(0 17.1333)">
<animateTransform attributeName="transform" type="translate" values="0 108;0 -8" keyTimes="0;1" dur="3s" begin="-1.35s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="80" cy="0" r="3" fill="#456caa" transform="translate(0 -17.98)">
<animateTransform attributeName="transform" type="translate" values="0 149;0 -49" keyTimes="0;1" dur="3s" begin="-1.53s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="65" cy="0" r="2" fill="#456caa" transform="translate(0 41.7667)">
<animateTransform attributeName="transform" type="translate" values="0 115;0 -15" keyTimes="0;1" dur="3s" begin="-0.69s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="95" cy="0" r="2" fill="#456caa" transform="translate(0 -3.04667)">
<animateTransform attributeName="transform" type="translate" values="0 123;0 -23" keyTimes="0;1" dur="3s" begin="-1.59s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="16" cy="0" r="2" fill="#456caa" transform="translate(0 76.2933)">
<animateTransform attributeName="transform" type="translate" values="0 108;0 -8" keyTimes="0;1" dur="3s" begin="-2.82s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="88" cy="0" r="3" fill="#456caa" transform="translate(0 102.733)">
<animateTransform attributeName="transform" type="translate" values="0 120;0 -20" keyTimes="0;1" dur="3s" begin="-2.37s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="12" cy="0" r="3" fill="#456caa" transform="translate(0 -5.22667)">
<animateTransform attributeName="transform" type="translate" values="0 126;0 -26" keyTimes="0;1" dur="3s" begin="-1.59s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="37" cy="0" r="2" fill="#456caa" transform="translate(0 105.833)">
<animateTransform attributeName="transform" type="translate" values="0 117;0 -17" keyTimes="0;1" dur="3s" begin="-2.25s" repeatCount="indefinite"></animateTransform>
</circle><circle cx="53" cy="0" r="2" fill="#456caa" transform="translate(0 -6.06667)">
<animateTransform attributeName="transform" type="translate" values="0 108;0 -8" keyTimes="0;1" dur="3s" begin="-1.95s" repeatCount="indefinite"></animateTransform>
</circle></pattern></defs>
      <path fill="url(#lds-flask-patid-704df534f7921)" clip-path="url(#lds-flask-cpid-72eef79003011)" d="M59,37.3V18.9c3-0.8,5.1-3.6,5.1-6.8C64.1,8.2,61,5,57.1,5H42.9c-3.9,0-7.1,3.2-7.1,7.1c0,3.2,2.2,6,5.1,6.8v18.4c-11.9,3.8-20.6,15-20.6,28.2C20.4,81.8,33.7,95,50,95s29.6-13.2,29.6-29.6C79.6,52.2,70.9,41.1,59,37.3z"></path>
      <path fill="none" stroke="#c2d2ee" stroke-width="5" d="M59,37.3V18.9c3-0.8,5.1-3.6,5.1-6.8C64.1,8.2,61,5,57.1,5H42.9c-3.9,0-7.1,3.2-7.1,7.1c0,3.2,2.2,6,5.1,6.8v18.4c-11.9,3.8-20.6,15-20.6,28.2C20.4,81.8,33.7,95,50,95s29.6-13.2,29.6-29.6C79.6,52.2,70.9,41.1,59,37.3z"></path>
</svg>',
    // Blue cat
    '<svg xmlns="http://www.w3.org/2000/svg" class="lds-bluecat" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
      <g transform="rotate(293.691 50 50)">
        <animateTransform attributeName="transform" type="rotate" values="360 50 50;0 50 50" keyTimes="0;1" dur="1.5s" repeatCount="indefinite" calcMode="spline" keySplines="0.5 0 0.5 1" begin="-0.15000000000000002s"/>
        <circle cx="50" cy="50" r="39.891" stroke="#6994b7" stroke-width="14.4" fill="none" stroke-dasharray="0 300">
          <animate attributeName="stroke-dasharray" values="15 300;55.1413599195142 300;15 300" keyTimes="0;0.5;1" dur="1.5s" repeatCount="indefinite" calcMode="linear" keySplines="0 0.4 0.6 1;0.4 0 1 0.6" begin="-0.069s"/>
        </circle>
        <circle cx="50" cy="50" r="39.891" stroke="#eeeeee" stroke-width="7.2" fill="none" stroke-dasharray="0 300">
          <animate attributeName="stroke-dasharray" values="15 300;55.1413599195142 300;15 300" keyTimes="0;0.5;1" dur="1.5s" repeatCount="indefinite" calcMode="linear" keySplines="0 0.4 0.6 1;0.4 0 1 0.6" begin="-0.069s"/>
        </circle>
        <circle cx="50" cy="50" r="32.771" stroke="#000000" stroke-width="1" fill="none" stroke-dasharray="0 300">
          <animate attributeName="stroke-dasharray" values="15 300;45.299378454348094 300;15 300" keyTimes="0;0.5;1" dur="1.5s" repeatCount="indefinite" calcMode="linear" keySplines="0 0.4 0.6 1;0.4 0 1 0.6" begin="-0.069s"/>
        </circle>
        <circle cx="50" cy="50" r="47.171" stroke="#000000" stroke-width="1" fill="none" stroke-dasharray="0 300">
          <animate attributeName="stroke-dasharray" values="15 300;66.03388996804073 300;15 300" keyTimes="0;0.5;1" dur="1.5s" repeatCount="indefinite" calcMode="linear" keySplines="0 0.4 0.6 1;0.4 0 1 0.6" begin="-0.069s"/>
        </circle>
      </g>

      <g transform="rotate(331.868 50 50)">
        <animateTransform attributeName="transform" type="rotate" values="360 50 50;0 50 50" keyTimes="0;1" dur="1.5s" repeatCount="indefinite" calcMode="spline" keySplines="0.5 0 0.5 1"/>
	<path fill="#6994b7" stroke="#000000" d="M97.2,50.1c0,6.1-1.2,12.2-3.5,17.9l-13.3-5.4c1.6-3.9,2.4-8.2,2.4-12.4"/>
	<path fill="#eeeeee" d="M93.5,49.9c0,1.2,0,2.7-0.1,3.9l-0.4,3.6c-0.4,2-2.3,3.3-4.1,2.8l-0.2-0.1c-1.8-0.5-3.1-2.3-2.7-3.9l0.4-3 c0.1-1,0.1-2.3,0.1-3.3"/>
	<path fill="#6994b7" stroke="#000000" d="M85.4,62.7c-0.2,0.7-0.5,1.4-0.8,2.1c-0.3,0.7-0.6,1.4-0.9,2c-0.6,1.1-2,1.4-3.2,0.8c-1.1-0.7-1.7-2-1.2-2.9 c0.3-0.6,0.5-1.2,0.8-1.8c0.2-0.6,0.6-1.2,0.7-1.8"/>
	<path fill="#6994b7" stroke="#000000" d="M94.5,65.8c-0.3,0.9-0.7,1.7-1,2.6c-0.4,0.9-0.7,1.7-1.1,2.5c-0.7,1.4-2.3,1.9-3.4,1.3h0 c-1.1-0.7-1.5-2.2-0.9-3.4c0.4-0.8,0.7-1.5,1-2.3c0.3-0.8,0.7-1.5,0.9-2.3"/>
      </g>
      <g transform="rotate(293.691 50 50)">
        <animateTransform attributeName="transform" type="rotate" values="360 50 50;0 50 50" keyTimes="0;1" dur="1.5s" repeatCount="indefinite" calcMode="spline" keySplines="0.5 0 0.5 1" begin="-0.15000000000000002s"/>
        <path fill="#eeeeee" stroke="#000000" d="M86.9,35.3l-6,2.4c-0.4-1.2-1.1-2.4-1.7-3.5c-0.2-0.5,0.3-1.1,0.9-1C82.3,33.8,84.8,34.4,86.9,35.3z"/>
        <path fill="#eeeeee" stroke="#000000" d="M87.1,35.3l6-2.4c-0.6-1.7-1.5-3.3-2.3-4.9c-0.3-0.7-1.2-0.6-1.4,0.1C88.8,30.6,88.2,33,87.1,35.3z"/>
        <path fill="#6994b7" stroke="#000000" d="M82.8,50.1c0-3.4-0.5-6.8-1.6-10c-0.2-0.8-0.4-1.5-0.3-2.3c0.1-0.8,0.4-1.6,0.7-2.4c0.7-1.5,1.9-3.1,3.7-4l0,0 c1.8-0.9,3.7-1.1,5.6-0.3c0.9,0.4,1.7,1,2.4,1.8c0.7,0.8,1.3,1.7,1.7,2.8c1.5,4.6,2.2,9.5,2.3,14.4"/>
        <path fill="#eeeeee" d="M86.3,50.2l0-0.9l-0.1-0.9l-0.1-1.9c0-0.9,0.2-1.7,0.7-2.3c0.5-0.7,1.3-1.2,2.3-1.4l0.3,0 c0.9-0.2,1.9,0,2.6,0.6c0.7,0.5,1.3,1.4,1.4,2.4l0.2,2.2l0.1,1.1l0,1.1"/>
        <path fill="#ff9922" d="M93.2,34.6c0.1,0.4-0.3,0.8-0.9,1c-0.6,0.2-1.2,0.1-1.4-0.2c-0.1-0.3,0.3-0.8,0.9-1 C92.4,34.2,93,34.3,93.2,34.6z"/>
        <path fill="#ff9922" d="M81.9,38.7c0.1,0.3,0.7,0.3,1.3,0.1c0.6-0.2,1-0.6,0.9-0.9c-0.1-0.3-0.7-0.3-1.3-0.1 C82.2,38,81.8,38.4,81.9,38.7z"/>
        <path fill="#000000" d="M88.5,36.8c0.1,0.3-0.2,0.7-0.6,0.8c-0.5,0.2-0.9,0-1.1-0.3c-0.1-0.3,0.2-0.7,0.6-0.8C87.9,36.3,88.4,36.4,88.5,36.8z"/>
        <path stroke="#000000" d="M85.9,38.9c0.2,0.6,0.8,0.9,1.4,0.7c0.6-0.2,0.9-0.9,0.6-2.1c0.3,1.2,1,1.7,1.6,1.5c0.6-0.2,0.9-0.8,0.8-1.4"/>
        <path fill="#6994b7" stroke="#000000" d="M86.8,42.3l0.4,2.2c0.1,0.4,0.1,0.7,0.2,1.1l0.1,1.1c0.1,1.2-0.9,2.3-2.2,2.3c-1.3,0-2.5-0.8-2.5-1.9l-0.1-1 c0-0.3-0.1-0.6-0.2-1l-0.3-1.9"/>
        <path fill="#6994b7" stroke="#000000" d="M96.2,40.3l0.5,2.7c0.1,0.5,0.2,0.9,0.2,1.4l0.1,1.4c0.1,1.5-0.9,2.8-2.2,2.9h0c-1.3,0-2.5-1.1-2.6-2.4 L92.1,45c0-0.4-0.1-0.8-0.2-1.2l-0.4-2.5"/>
        <path fill="#000000" d="M91.1,34.1c0.3,0.7,0,1.4-0.7,1.6c-0.6,0.2-1.3-0.1-1.6-0.7c-0.2-0.6,0-1.4,0.7-1.6C90.1,33.1,90.8,33.5,91.1,34.1z"/>
        <path fill="#000000" d="M85.5,36.3c0.2,0.6-0.1,1.2-0.7,1.5c-0.6,0.2-1.3,0-1.5-0.6C83,36.7,83.4,36,84,35.8C84.6,35.5,85.3,35.7,85.5,36.3z"/>

      </g></svg>'
];
$loadingIcon = $loadingIcons[rand(0, count($loadingIcons) - 1)];
$loadingIcon = str_replace(["/\r|\n/", "#", "/"], ["", "%23", "%2F"], preg_replace("/\r|\n/", "", $loadingIcon));
?>
<div id="quiz-play-root"></div>

<style>
    .loading-icon {
        background-image: url("data:image/svg+xml,\
    <svg version='1.1' id='Layer_1' xmlns='http:%2F%2Fwww.w3.org%2F2000%2Fsvg' xmlns:xlink='http:%2F%2Fwww.w3.org%2F1999%2Fxlink' x='0px' y='0px' width='24px' height='30px' viewBox='0 0 24 30' style='enable-background:new 0 0 50 50;' xml:space='preserve'>\
    <rect x='0' y='10' width='4' height='10' fill='%23333' opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <rect x='8' y='10' width='4' height='10' fill='%23333'  opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <rect x='16' y='10' width='4' height='10' fill='%23333'  opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <%2Fsvg>\
    ");
        width: 1em;
        height: 1em;
    }
    .quiz-msg-overlay {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: transparent;
        z-index: 100;
    }
    .quiz-msg-inner {
        text-align: center;
        width: 210px;
        margin: 50px auto 0;
        background: #fff;
        padding: 10px;
        border-radius: 3px;
        border: 1px solid #999;
        box-shadow: 0 1px 12px rgba(0,0,0,0.4);
        -webkit-box-shadow: 0 1px 12px rgba(0,0,0,0.4);
    }
    .quiz-msg-large {
        width: 350px;
    }
    .quiz-msg-inner a {
        color: royalblue;
        font-weight: bold;
    }
    .quiz-msg-inner a:hover {
        text-decoration: underline;
    }
    .quiz-msg-text {

    }
    .quiz-msg-inner .quiz--button--login {
        font-size: 1.2em;
        margin-top: 1em;
        cursor: pointer;
    }
    .quiz--loading-box--icon {
        background-image: url('data:image/svg+xml;utf8,<?= $loadingIcon ?>');
    }
    .quiz--button--login {
        font-size: 1.4em;
    }
    .quiz--button--login * {
        display: inline-block;
        vertical-align: middle;
    }
    .quiz--button--login:before {
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 0.5em;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" viewBox="0 0 408.788 408.788"><path d="M353.7 0H55.088C24.665 0 .002 24.662.002 55.085V353.7c0 30.424 24.662 55.086 55.085 55.086h147.275l.25-146.078h-37.95c-4.932 0-8.935-3.988-8.954-8.92l-.182-47.087c-.02-4.958 3.996-8.988 8.955-8.988h37.883v-45.498c0-52.8 32.247-81.55 79.348-81.55h38.65c4.946 0 8.956 4.01 8.956 8.955v39.703c0 4.944-4.007 8.952-8.95 8.955l-23.72.01c-25.614 0-30.574 12.173-30.574 30.036v39.39h56.285c5.363 0 9.524 4.682 8.892 10.008l-5.582 47.087c-.534 4.505-4.355 7.9-8.892 7.9h-50.453l-.25 146.078h87.63c30.422 0 55.084-24.662 55.084-55.084V55.084C408.787 24.663 384.124 0 353.7 0z" fill="white"%2F><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    #quiz-play-root .quiz--button--share {
        background: none;
        border: none;
        padding: 0;
    }
    .quiz--container {
        max-width: 600px;
    }
    .quiz--markdown a {
        color: #06b;
    }
    .quiz--markdown a:hover {
        text-decoration: underline;
    }
    .quiz--markdown a * {
        display: inline;
        vertical-align: middle;
    }


    /**
     * Share and Send buttons
     */
    .fb-logo-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" viewBox="0 0 408.788 408.788"><path d="M353.7 0H55.088C24.665 0 .002 24.662.002 55.085V353.7c0 30.424 24.662 55.086 55.085 55.086h147.275l.25-146.078h-37.95c-4.932 0-8.935-3.988-8.954-8.92l-.182-47.087c-.02-4.958 3.996-8.988 8.955-8.988h37.883v-45.498c0-52.8 32.247-81.55 79.348-81.55h38.65c4.946 0 8.956 4.01 8.956 8.955v39.703c0 4.944-4.007 8.952-8.95 8.955l-23.72.01c-25.614 0-30.574 12.173-30.574 30.036v39.39h56.285c5.363 0 9.524 4.682 8.892 10.008l-5.582 47.087c-.534 4.505-4.355 7.9-8.892 7.9h-50.453l-.25 146.078h87.63c30.422 0 55.084-24.662 55.084-55.084V55.084C408.787 24.663 384.124 0 353.7 0z" fill="white"%2F><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    .fb-msg-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" width="24" height="24" viewBox="96 93 322 324"><path d="M257 93c-88.918 0-161 67.157-161 150 0 47.205 23.412 89.311 60 116.807V417l54.819-30.273C225.449 390.801 240.948 393 257 393c88.918 0 161-67.157 161-150S345.918 93 257 93zm16 202l-41-44-80 44 88-94 42 44 79-44-88 94z" fill="white"><%2Fpath><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    .fb-bt-inner-share,
    .fb-bt-inner-send {
        padding: 0.6rem;
        transition: all 100ms;
    }
    .fb-bt-inner-share > *,
    .fb-bt-inner-send > * {
        display: inline-block;
        vertical-align: middle;
    }
    .fb-bt-inner-share {
        background-color: #4169b7;
    }
    .fb-bt-inner-send {
        background-color: #4080FF;
    }
    .quiz--button--share:hover .fb-bt-inner-share {
        background-color: #365899;
    }
    .quiz--button--share:hover .fb-bt-inner-send {
        background-color: #3E7CF7;
    }
    .quiz--loading-overlay {
        background-color: rgba(255,255,255,0.8);
    }
    .quiz--loading-overlay--message {
        color: #000;
    }
    @media screen and (max-width: 400px) {
        .quiz--button--share {
            font-size: 1.2em;
        }
        .quiz--button--login {
            font-size: 1.2em;
        }
    }
</style>

<script>
    window.QuizPlayMessages = {
        "Start": "<?= Yii::t('app', "Start") ?>",
        "Login": "<?= Yii::t('app', "Continue with Facebook") ?>",
        "Share": "<?= Yii::t('app', "Share with friends") ?>",
        "Wait for a minute": "<?= Yii::t('app', "Wait for a minute...") ?>",
        "Loading": "<?= Yii::t('app', "Loading...") ?>",
        "Processing": "<?= Yii::t('app', "Processing...") ?>",
        "Loading images for canvas-based questions": "<?= Yii::t('app', "Loading images...") ?>",
        "Next": "<?= Yii::t('app', "Next") ?>",
        "Try again": "<?= Yii::t('app', "Try again!") ?>",
        "This is required": "<?= Yii::t('app', "This is required!") ?>",
        "Please fulfill this word": "<?= Yii::t('app', "Please fulfill this word!") ?>",
        "Common remaining time": "<?= Yii::t('app', "Common remaining time") ?>",
        "Group remaining time": "<?= Yii::t('app', "Group remaining time") ?>",
        "Total time": "<?= Yii::t('app', "Total time") ?>",
        "All questions answering time": "<?= Yii::t('app', "All questions answering time") ?>",
        "Closed questions answering time": "<?= Yii::t('app', "Closed questions answering time") ?>",
        "Failed to load images": "<?= Yii::t('app', "Failed to load images :(") ?>",
        "Failed to get sharing data": "<?= Yii::t('app', "Failed to get sharing data :(") ?>",
        "Wait for sharing data": "<?= Yii::t('app', 'Already have the result...') ?>",
        "Loading layers for result canvas": "<?= Yii::t('app', 'Calculating result...') ?>"
    };
    window.QuizPlayRoot = document.getElementById("quiz-play-root");
    if (window.QuizPlayProps) {
        if ("undefined" == typeof window.QuizPlayProps.login) {
            window.QuizPlayProps.login = fbLogin;
        }
        if ("undefined" == typeof window.QuizPlayProps.shareButtons) {
            window.QuizPlayProps.shareButtons = {
                below: [
                    {
                        method: fbShare,
                        html: "<div class='fb-bt-inner-share'><i class='icon fb-logo-icon'></i> <span><?= Yii::t('app', 'Share with friends') ?></span></div>"
                    },
                    {
                        method: fbSend,
                        html: "<div class='fb-bt-inner-send'><i class='icon fb-msg-icon'></i></div>"
                    }
                ]
            };
        }
        if ("undefined" == typeof window.QuizPlayProps.requestCharacterRealData) {
            window.QuizPlayProps.requestCharacterRealData = requestUserData;
        }
        if ("undefined" == typeof window.QuizPlayProps.getSharingData) {
            window.QuizPlayProps.getSharingData = getSharingData;
        }
    }
    //==============================================
    var serverLoggedIn = <?= Yii::$app->user->isGuest ? 'false' : 'true' ?>;
    var quizCompleted = false;
    var cacheDuration = 3 * 86400 * 1000;
    var userID;
    var accessToken;
    var friendsData = [];
    function requestUserData(userType, media, callback) {
        switch (userType) {
            case "Player":
                getUserData(userID, accessToken, function (userData) {
                    var mediaData = {};
                    var mediaLoaded = 0;
                    media.forEach(function (medium) {
                        switch (medium.type) {
                            case "Avatar":
                                mediaData.Avatar = [];
                                getUserAvatarData(
                                    userID,
                                    medium.width,
                                    medium.height,
                                    function (mediumData) {
                                        mediaData.Avatar.push(mediumData);
                                        mediaLoaded++;
                                    }
                                );
                                break;
                            case "Post":
                                mediaData.Post = [];
                                getUserPostData(
                                    userID,
                                    function (mediumData) {
                                        console.log("Posts", mediumData);
                                        mediaData.Post = mediumData;
                                        mediaLoaded++;
                                    }
                                );
                                break;
                            case "Photo":
                                mediaData.Photo = [];
                                getUserPhotoData(
                                    userID,
                                    function (mediumData) {
                                        console.log("Photos", mediumData);
                                        mediaData.Photo = mediumData;
                                        mediaLoaded++;
                                    }
                                );
                                break;

                        }
                    });
                    var interval = setInterval(function () {
                        if (mediaLoaded == media.length) {
                            clearInterval(interval);
                            userData.media = mediaData;
                            callback([userData]);
                        }
                    }, 10);
                });
                break;
            case "PlayerFriend":
                var cacheKey = "quiz/user/__userID__/posts".split("__userID__").join(userID);

                var cachedPosts = getCachedData(cacheKey);

                var getFriendsDataFromPostsAndCallback = function (posts) {
                    /* handle the result */
                    var commentIntimateLevel = 3;
                    var likeIntimateLevel = 1;
                    var addFriend = function (thisFriend, intimateLevel) {
                        if (thisFriend.id == userID) {
                            return;
                        }
                        var existingFriend = friendsData.find(function (friend) {
                            return friend.id == thisFriend.id;
                        });
                        if (existingFriend) {
                            existingFriend.intimate_level += intimateLevel;
                        } else {
                            friendsData.push({
                                id: thisFriend.id,
                                name: thisFriend.name,
                                intimate_level: intimateLevel
                            });
                        }
                    };
                    posts.forEach(function (post) {
                        if (post.comments) {
                            post.comments.data.forEach(function (commentData) {
                                addFriend(commentData.from, commentIntimateLevel);
                            });
                        }
                        if (post.likes) {
                            post.likes.data.forEach(function (liker) {
                                addFriend(liker, likeIntimateLevel);
                            });
                        }
                    });
                    var tryCount = 0;
                    var tryCountMax = 1000;
                    var tryDelay = 10;
                    var totalMediaLoaded = 0;
                    var tryInterval = setInterval(function () {
                        tryCount++;
                        console.log(totalMediaLoaded, media.length, friendsData.length);
                        if (totalMediaLoaded == media.length * friendsData.length || tryCount == tryCountMax) {
                            clearInterval(tryInterval);
                            callback(friendsData);
                            console.log("friendsData", friendsData);
                        }
                    }, tryDelay);
                    friendsData.forEach(function (friend) {
                        var friendID = friend.id;
                        friend.media = {};
                        media.forEach(function (medium) {
                            switch (medium.type) {
                                case "Avatar":
                                    friend.media.Avatar = [];
                                    getUserAvatarData(
                                        friendID,
                                        medium.width,
                                        medium.height,
                                        function (mediumData) {
                                            friend.media.Avatar.push(mediumData);
                                            totalMediaLoaded++;
                                        }
                                    );
                                    break;
                            }
                        });
                        //                                getUserData(friendID, accessToken, function (friendData) {
                        //                                    var mediaData = {};
                        //                                    var mediaLoaded = 0;
                        //                                    media.forEach(function (medium) {
                        //                                        switch (medium.type) {
                        //                                            case "Avatar":
                        //                                                mediaData.Avatar = [];
                        //                                                getUserAvatarData(
                        //                                                    friendID,
                        //                                                    medium.width,
                        //                                                    medium.height,
                        //                                                    function (mediumData) {
                        //                                                        mediaData.Avatar.push(mediumData);
                        //                                                        mediaLoaded++;
                        //                                                    }
                        //                                                );
                        //                                                break;
                        //                                        }
                        //                                    });
                        //                                    var interval = setInterval(function () {
                        //                                        if (mediaLoaded == media.length) {
                        //                                            clearInterval(interval);
                        //                                            friendData.media = mediaData;
                        //                                            friendsData.push(friendData);
                        //                                        }
                        //                                    }, 10);
                        //                                });
                    });
                };

                if (cachedPosts && cachedPosts.length > 9) {
                    getFriendsDataFromPostsAndCallback(cachedPosts);
                } else {
                    var requestFriendsData = function () {
                        console.log("get posts data");
                        FB.api(
                            "/" + userID + "/posts?fields=comments,likes",
                            function (response) {
                                if (response && !response.error) {
                                    getFriendsDataFromPostsAndCallback(response.data);

                                    // TODO: Cache posts
                                    setCachedData(cacheKey, response.data);
                                } else {
                                    callback();
                                }
                            }
                        );
                    };
                    var checkingPerm = false;
                    var checkPermAndReRequestIfNotGranted = function () {
                        if (checkingPerm) {
                            return;
                        }
                        checkingPerm = true;
                        FB.api('/me/permissions', function (response) {
                            //                    { "data": [
                            //                        {
                            //                            "permission": "user_birthday",
                            //                            "status": "granted"
                            //                        },
                            //                        {
                            //                            "permission": "public_profile",
                            //                            "status": "granted"
                            //                        },
                            //                        {
                            //                            "permission": "email",
                            //                            "status": "declined"
                            //                        }
                            //                    ]}
                            var has_user_posts_perm = false;
                            console.log("response.data");
                            console.log(response.data);
                            response.data.forEach(function (item) {
                                console.log(item);
                                if ("user_posts" == item.permission && "granted" == item.status) {
                                    has_user_posts_perm = true;
                                }
                            });
                            console.log("has_user_posts_perm", has_user_posts_perm);
                            if (has_user_posts_perm) {
                                requestFriendsData();
                            } else {
                                var reLoginBtn = element(
                                    "button",
                                    "<?= Yii::t("app", "Continue with Facebook")?>",
                                    {"class": "quiz--button--login"}
                                );

                                var msgOverlay = element(
                                    "div",
                                    element(
                                        "div",
                                        [
                                            element(
                                                "p",
                                                "<?= Yii::t("app", "This quiz need permission to access your posts, continue? ")?>",
                                                {"class": "quiz-msg-text", "align": "justify"}),
                                            reLoginBtn
                                        ],
                                        {"class": "quiz-msg-inner quiz-msg-large"}
                                    ),
                                    {"class": "quiz-msg-overlay"}
                                );

                                QuizPlayRoot.appendChild(msgOverlay);

                                reLoginBtn.onclick = function () {
                                    FB.login(function (loginResponse) {
                                        if (msgOverlay.parentNode) {
                                            msgOverlay.parentNode.removeChild(msgOverlay);
                                        }
                                        checkingPerm = false;
                                        checkPermAndReRequestIfNotGranted();
                                    }, {scope: 'user_posts', auth_type: 'rerequest'});
                                };
                            }
                        });
                    };
                    checkPermAndReRequestIfNotGranted();
                }

                break;
        }
    }

    function getCachedData(key) {
        var cachedDataString = localStorage.getItem(key);
        if (cachedDataString) {
            var cachedData = JSON.parse(cachedDataString);
            var time = cachedData.time;
            var now = new Date().getTime();
            console.log("get cached data, now - time - dur = ", new Date().getTime() - time - cacheDuration);
            console.log("get cached data, now_to_string - time - dur = ", new Date().getTime().toString() - time - cacheDuration);
            if (now - time - cacheDuration > 0) {
                localStorage.removeItem(key);
            } else {
                return cachedData.value;
            }
        }
        return null;
    }

    function setCachedData(key, value) {
        var cachedData = {
            time: new Date().getTime(),
            value: value
        };
        console.log("set cached data, time= ", new Date().getTime(), "time_to_string=", new Date().getTime().toString());
        var cachedDataString = JSON.stringify(cachedData);
        localStorage.setItem(key, cachedDataString);
    }
    
    function getUserAvatarData(_userID, width, height, callback) {
        var server_image_src = "<?=
            Url::to([
                '/user/get-facebook-avatar',
                'userID' => '__userID__',
                'width' => '__width__',
                'height' => '__height__'
            ])
            ?>"
            .split("__userID__").join(_userID)
            .split("__width__").join(width)
            .split("__height__").join(height);

        var cacheKey = "quiz/user/__userID__/avatar/__width__x__height__"
            .split("__userID__").join(_userID)
            .split("__width__").join(width)
            .split("__height__").join(height);

        var image_src = getCachedData(cacheKey);

        if (image_src) {
            callback({
                image_src: image_src
            });
        } else {
            callback({
                image_src: server_image_src
            });

            // Cache image data
            var caching = setInterval(function () {
                if (quizCompleted) {
                    clearInterval(caching);
                    var image = new Image();
                    image.src = server_image_src;
                    image.addEventListener("load", function () {
                        var canvas = document.createElement("canvas");
                        var ctx = canvas.getContext("2d");
                        canvas.width = image.naturalWidth;
                        canvas.height = image.naturalHeight;
                        ctx.drawImage(image, 0, 0);
                        setCachedData(cacheKey, canvas.toDataURL("image/jpeg"));
                    });
                }
            }, 100);
        }

    }

    function getUserPhotoData(_userID, callback) {

    }

    function getUserPostData(_userID, callback) {
        var cacheKey = "quiz/user/__userID__/posts.171102".split("__userID__").join(_userID);

        var cachedPosts = getCachedData(cacheKey);

        if (cachedPosts) {
            callback(cachedPosts);
        } else {
            var requestFriendsData = function () {
                console.log("get posts data");
                FB.api(
                    "/" + userID + "/posts?limit=500&fields=message,description,caption,created_time,updated_time,comments.limit(1000).summary(true),likes.limit(1000).summary(true),reactions.limit(1000).summary(true)",
                    function (response) {
                        if (response && !response.error) {
                            var posts = [];
                            if (response.data instanceof Array) {
                                response.data.forEach(function (item) {
//                                    var post = {
//                                        message: item.message || "",
//                                        description: item.description || "",
//                                        caption: item.caption || "",
//                                        reactions: item.reactions ? item.reactions.data : [],
//                                        comments: item.comments ? item.comments.data : [],
//                                        likes: item.likes ? item.likes.data : [],
//                                        created_time: item.created_time,
//                                        updated_time: item.updated_time
//                                    };
                                    var post = item;
                                    posts.push(post);
                                });
                            }
                            callback(posts);

                            // TODO: Cache posts
                            setCachedData(cacheKey, posts);
                        } else {
                            callback();
                        }
                    }
                );
            };
            var checkingPerm = false;
            var checkPermAndReRequestIfNotGranted = function () {
                if (checkingPerm) {
                    return;
                }
                checkingPerm = true;
                FB.api('/me/permissions', function (response) {
                    var has_user_posts_perm = false;
                    console.log("response.data");
                    console.log(response.data);
                    response.data.forEach(function (item) {
                        console.log(item);
                        if ("user_posts" == item.permission && "granted" == item.status) {
                            has_user_posts_perm = true;
                        }
                    });
                    console.log("has_user_posts_perm", has_user_posts_perm);
                    if (has_user_posts_perm) {
                        requestFriendsData();
                    } else {
                        var reLoginBtn = element(
                            "button",
                            "<?= Yii::t("app", "Continue with Facebook")?>",
                            {"class": "quiz--button--login"}
                        );

                        var msgOverlay = element(
                            "div",
                            element(
                                "div",
                                [
                                    element(
                                        "p",
                                        "<?= Yii::t("app", "This quiz need permission to access your posts, continue? ")?>",
                                        {"class": "quiz-msg-text", "align": "justify"}),
                                    reLoginBtn
                                ],
                                {"class": "quiz-msg-inner quiz-msg-large"}
                            ),
                            {"class": "quiz-msg-overlay"}
                        );

                        QuizPlayRoot.appendChild(msgOverlay);

                        reLoginBtn.onclick = function () {
                            FB.login(function (loginResponse) {
                                if (msgOverlay.parentNode) {
                                    msgOverlay.parentNode.removeChild(msgOverlay);
                                }
                                checkingPerm = false;
                                checkPermAndReRequestIfNotGranted();
                            }, {scope: 'user_posts', auth_type: 'rerequest'});
                        };
                    }
                });
            };
            checkPermAndReRequestIfNotGranted();
        }
    }
    function getUserData(_userID, accessToken, callback) {
        var cacheKey = "quiz/user/__userID__/info"
            .split("__userID__").join(_userID);

        var data = getCachedData(cacheKey);

        if (data) {
            callback(data);
        } else {
            console.log("getUserData", _userID, accessToken);
            var fd = new FormData();
            fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
            fd.append("userID", _userID);
            fd.append("accessToken", accessToken);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= Url::to(['/user/get-facebook-data']) ?>", true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var response = JSON.parse(this.response);
                    console.log("user data", response);
                    if (response && !response.errorMsg) {
                        callback(response.data);
                        setCachedData(cacheKey, response.data);
                    }
                } else {
                    alert("<?= Yii::t('app', 'Connection error! Please refresh this page and try again') ?>");
                }
            };
            xhr.upload.onprogress = function (event) {
            };
            xhr.send(fd);
        }

    }

    function ajaxServerLogin(callback) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/user/login-with-facebook']) ?>", true);
        xhr.onload = function () {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                console.log("response", response);
                if (!response.errorMsg) {
                    // Callback to continue Quiz
//                        userID = response.data.userID;
//                        accessToken = response.data.accessToken;
                    console.log("userID, accessToken", userID, accessToken);
                    console.log("ajax server login userData", response.data);
                    var cacheKey = "quiz/user/__userID__/info"
                        .split("__userID__").join(userID);
                    if (response.data.info && response.data.info.name) {
                        setCachedData(cacheKey, response.data.info);
                    }
                    if ("function" == typeof callback) {
                        callback();
                    }
                } else {
                    alert("<?= Yii::t('app', 'Login error') ?>" + ": " + response.errorMsg);
                }
            } else {
                alert("<?= Yii::t('app', 'Connection error! Please refresh this page and try again') ?>");
            }
        };
        xhr.upload.onprogress = function (event) {
        };
        xhr.send(fd);
    }

    var fb_login_status = '';

    function fbLogin(callback) {
        console.log("fbLogin");
        console.log("fb_login_status", fb_login_status);
        if ("connected" == fb_login_status) {
            callback();
        } else {

            var loadingMsg = element(
                "p",
                "<?= Yii::t('app', 'Connecting to Facebook...')?>",
                {"class": "quiz-msg-text"}
            );

            var loadingSpinner = element("i", null, {"class": "icon loading-icon"});

            var loadingF5 = element(
                "p",
                [
                    "<?= Yii::t('app', 'Wait too long')?>, ",
                    element("a", "<?= Yii::t('app', 'Click here')?>", {"href": window.location.href})
                ]
            );

            var loadingInner = element(
                "div",
                [loadingSpinner, loadingMsg],
                {"class": "quiz-msg-inner"}
            );

            var loadingOverlay = element(
                "div",
                loadingInner,
                {"class": "quiz-msg-overlay"}
            );

            var loginBtn = element(
                "button",
                "<?= Yii::t('app', "Continue with Facebook")?>",
                {"class": "quiz--button--login"}
            );

            QuizPlayRoot.appendChild(loadingOverlay);

            var removeLoadingOverlay = function () {
                if (loadingOverlay.parentNode == QuizPlayRoot) {
                    QuizPlayRoot.removeChild(loadingOverlay);
                }
            };

            var tryCount = 0;

            var _fbLogin = function () {
                FB.login(function (response) {
                    console.log("FB login response", response);
                    removeLoadingOverlay();
                    if (response.authResponse) {
                        console.log('You are logged in and cookie set!');
                        // Login on server async to improve speed
                        accessToken = response.authResponse.accessToken;
                        userID = response.authResponse.userID;
                        callback();
                        ajaxServerLogin(function () {
                            console.log("Ajax server login response");
//                                removeLoadingOverlay();
//                                callback();
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: 'public_profile,email,user_posts'});
            };

            var _considerLogin = function () {
                if ("connected" == fb_login_status) {
                    console.log("fb_login_status= connected");
                    removeLoadingOverlay();
                    callback();
                } else {
                    loadingMsg.innerHTML = "<?= Yii::t('app', "Logging you in")?>";
                    if (tryCount > 0) {
                        loginBtn.onclick = _fbLogin;
                        loadingInner.classList.add("quiz-msg-large");
                        loadingInner.removeChild(loadingSpinner);
                        loadingInner.appendChild(loginBtn);
                    } else {
                        _fbLogin();
                    }
                }
            };

            if (fb_login_status) {
                _considerLogin();
            } else {
                var tryLogin = setInterval(function () {
                    tryCount++;
                    console.log("try login " + tryCount);
                    if (fb_login_status) {
                        clearInterval(tryLogin);
                        _considerLogin();
                    } else if (tryCount == 300) {
                        loadingInner.classList.add("quiz-msg-large");
                        loadingInner.appendChild(loadingF5);
                    }
                }, 100);
            }
        }
    }

    window.checkFBLoginStatus = function () {
        console.log("Check login status");
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                userID = response.authResponse.userID;
                accessToken = response.authResponse.accessToken;
                console.log("the user is logged in and has authenticated your app");

                if (!serverLoggedIn) {
                    ajaxServerLogin();
                }
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
                console.log("the user is logged in to Facebook, but has not authenticated your app");
            } else {
                // the user isn't logged in to Facebook.
                console.log("the user isn't logged in to Facebook");
            }
            fb_login_status = response.status;
        });
    };

    /**
     *
     * @param {Object} data
     * @param {String} data.image
     * @param {String} data.title
     * @param {String} data.description
     * @param {Function} callback
     * @param {HTMLElement} overlay
     * @param {HTMLElement} message
     */
    function getSharingData(data, callback, overlay, message) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("slug", window.QuizPlayProps ? window.QuizPlayProps.slug : '');
        fd.append("title", data.title);
        fd.append("description", data.description);
        fd.append("image", data.canvas.toDataURL("image/jpeg", 0.8));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/quiz/get-sharing-data']) ?>", true);
        xhr.onload = function () {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                if (response && !response.errorMsg) {
                    console.log(response.data);
                    callback({data: response.data, errorMsg: response.errorMsg});
                    quizCompleted = true;
                } else {
                    callback(false);
                }
            } else {
                callback(false);
            }
        };
        var percentElm = element("span");
        message.appendChild(percentElm);
        xhr.upload.onprogress = function (event) {
//            console.log(event.lengthComputable);
//            console.log(event.total);
//            console.log(event.loaded);
//            if (event.total == event.loaded) {
//                console.log("loaded 100%");
//            }
            var k =  event.loaded / event.total;
            var opacity = 0.5 + 0.3 * (1 - k);
            var percent = Math.round(99 * k);
            if (!isNaN(opacity)) {
                overlay.style.backgroundColor = "rgba(255,255,255," + opacity + ")";
                percentElm.innerHTML = " (" + percent + "%)";
            }
        };
        xhr.upload.onloadend = function(pe) {
            console.log(event.lengthComputable);
            console.log(event.total);
            console.log(event.loaded);
        };
        xhr.send(fd);
    }
    function fbShare(data, callback) {
        FB.ui({
                method: "share",
                display: isMobile() ? "touch" : "popup",
                href: data.url,
                picture: data.image_url,
                title: data.title || (window.QuizPlayProps ? window.QuizPlayProps.name : ''),
                description: data.description || (window.QuizPlayProps ? window.QuizPlayProps.description : ''),
                caption: <?= json_encode(Yii::$app->name) ?>,
                hashtag: "#horoquiz"
            }, // callback
            function (response) {
                if (response && !response.error_message) {
                    console.log('Posting completed.');
                } else {
                    console.log('Error while posting.');
                }
            });
    }

    function fbSend(data, callback) {
        if (isMobile()) {
            location.href = ("fb-messenger://share?link=" + data.url
            + "&app_id=<?= Yii::$app->params['facebook.appID'] ?>");
        } else {
            FB.ui({
                method: "send",
                display: "popup",
                link: data.url
            });
        }
    }

    function element(nodeName, content, attributes) {
        var node = document.createElement(nodeName);
        var append = function (t) {
            if ("string" == typeof t) {
                node.innerHTML += t;
            } else if (t instanceof HTMLElement) {
                node.appendChild(t);
            }
        };
        if (content instanceof Array) {
            content.forEach(function (item) {
                append(item);
            });
        } else {
            append(content);
        }
        if (attributes) {
            var attrName;
            for (attrName in attributes) {
                if (attributes.hasOwnProperty(attrName)) {
                    node.setAttribute(attrName, attributes[attrName])
                }
            }
        }
        return node;
    }

    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
</script>
