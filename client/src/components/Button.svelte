<script>
    export let inverted = false;
    let bg = 'blue'
    if (inverted) bg = 'red'
</script>

<button class="block bg-{bg}-500 rounded-md text-white mt-2 py-2 w-full"
    ><slot /></button
>
