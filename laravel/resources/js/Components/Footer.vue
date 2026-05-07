<template>
  <footer class="flex flex-col bg-gray-950 py-14 px-10 justify-around font-space" role="contentinfo">

    <div class="flex justify-around items-center font-space">

      <div class="flex flex-col gap-4">

        <div class="flex items-center">
          <div class="text-primary mr-2">CineVerse</div>
          <img :src="logo" class="h-6" alt="CineVerse logo" />
        </div>

        <div class="text-primary">
          Email: cineverse@mail.ru
        </div>

        <div class="text-primary">
          Chisinau, Moldova
        </div>

        <div class="text-primary">
          Mon - Fri: 10:00 - 22:00
        </div>

      </div>

      <div class="flex flex-col gap-5">

        <a class="text-primary flex" href="https://www.facebook.com/" aria-label="Facebook page" target="_blank">
          <img :src="facebook" class="h-6 pr-3" alt="Facebook icon" />
          <p>Facebook</p>
        </a>

        <a class="text-primary flex" href="https://www.instagram.com/" aria-label="Instagram page" target="_blank">
          <img :src="instagram" class="h-6 pr-3" alt="Instagram icon" />
          <p>Instagram</p>
        </a>

        <a class="text-primary flex" href="https://web.telegram.org/" aria-label="Telegram channel" target="_blank">
          <img :src="telegram" class="h-6 pr-3" alt="Telegram icon" />
          <p>Telegram</p>
        </a>

        <a class="text-primary flex" href="https://x.com/" aria-label="X social network page" target="_blank">
          <img :src="XCOM" class="h-6 pr-3" alt="X.com icon" />
          <p>X.com</p>
        </a>

      </div>

      <ul class="flex flex-col gap-6">

        <li>
          <a href="/main" aria-label="Go to Main page"
            class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
            Main
          </a>
        </li>

        <li>
          <a href="/program" aria-label="Go to Movies page"
            class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
            Movies
          </a>
        </li>

        <li>
          <a href="/price" aria-label="Go to Prices page"
            class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
            Prices
          </a>
        </li>

        <li>
          <a href="/contact" aria-label="Go to Contact page"
            class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
            Contact
          </a>
        </li>

        <li>
          <a href="/rules" aria-label="Go to Rules page"
            class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
            Rules
          </a>
        </li>

      </ul>

    </div>

    <div class="text-primary mx-auto mt-5" role="contentinfo">
      © 2026 CineVerse. All rights reserved.
    </div>

  </footer>
</template>

<script setup>
import logo from '@/assets/cineverse_logo.png'
import facebook from '@/assets/facebook.svg'
import instagram from '@/assets/instagram.svg'
import telegram from '@/assets/telegram.svg'
import XCOM from '@/assets/X.com.svg'
</script>