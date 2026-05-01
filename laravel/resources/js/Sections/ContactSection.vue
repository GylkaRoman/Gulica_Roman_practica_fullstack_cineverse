<template>
  <div class="container px-8 mt-10 text-white">

    <div class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6">
      Contact Us
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-primary">

      <div class="bg-gray-950 p-6 rounded-2xl ">

        <h2 class="font-bold mb-4">Send us a message</h2>

        <form @submit.prevent="sendMessage" class="flex flex-col gap-3 text-black">

          <input type="text" placeholder="Name" class="p-2 rounded bg-gray-800" required/>

          <input type="email" placeholder="Email" class="p-2 rounded bg-gray-800" required/>

          <textarea placeholder="Message" class="p-2 rounded h-32 bg-gray-800" require></textarea>

          <button class="bg-primary py-2 rounded font-bold hover:opacity-80 text-black">
            Send
          </button>

        </form>

        <div class="mt-6 space-y-2">

          <p>Phone: +373 11 111 111</p>
          <p>Email: cineverse@main.ru</p>
          <p>Address: Chisinau, Moldova</p>
          <p>Mon–Fri: 10:00 - 20:00</p>

        </div>

      </div>

      <div class="rounded-2xl overflow-hidden h-[400px]">

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1360.0357253526063!2d28.823085699999982!3d47.01920250000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97c2d03e2c6b1%3A0xd8e8b74ac8c3ef7b!2z0JzQvtC70LTQsNCy0YHQutC40Lkg0JPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INCj0L3QuNCy0LXRgNGB0LjRgtC10YI!5e0!3m2!1sru!2s!4v1777564188862!5m2!1sru!2s"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>

      </div>

    </div>

  </div>
</template>