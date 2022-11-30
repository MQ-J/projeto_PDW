<script>
    export let inverted = false;
    let bg = "blue";
    export let disabled;
    if (inverted) bg = "red";
</script>

<button disabled={disabled} class="block bg-{bg}-500 rounded-md text-white mt-2 py-2 w-full"
    ><slot /></button
>
