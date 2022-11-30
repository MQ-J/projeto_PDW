<script>
    import Menu from "../components/Menu.svelte";
    import Button from "../components/Button.svelte";

    import { menuPermalink } from "../store.js";
    import { afterUpdate } from "svelte";
    import {
        listBlocks,
        createBlocks,
        destroyBlock,
        updateBlocks,
    } from "../services/block.service";

    let permalink = "";

    let blocks = listBlocks(permalink);

    menuPermalink.subscribe((value) => {
        permalink = value;
    });

    function refreshBlocks() {
        blocks = listBlocks(permalink);
    }

    afterUpdate(refreshBlocks);

    let blockText = "";
    let blockId = -1;

    function handleBlockForm(e) {
        e.preventDefault();
        const target = e.target;
        if (blockText.length > 0 && blockId != -1) {
            updateBlocks(permalink, blockId, blockText).then(() => {
                blockText = "";
                blockId = -1;
            });
        } else createBlocks(permalink, target.text.value).then(refreshBlocks);
    }

    function edit(block) {
        blockText = block.text;
        blockId = block.id;
    }
</script>

{permalink}

<Menu />
<div style="width: 400px">
    {#await blocks}
        Loading blocks
    {:then blockItems}
        {#each blockItems.data as block}
            <div class="bg-gray-200 my-1 p-2">
                <span on:click={edit(block)}>{block.text}</span>
                <button
                    class="bg-red-500 text-white px-2 rounded-full m-1"
                    on:click={() => {
                        destroyBlock(permalink, block.id).then(refreshBlocks);
                    }}>x</button
                >
            </div>
        {/each}
    {/await}
    <form on:submit={handleBlockForm} class="border p-2 my-2">
        <h2 class="text-lg font-bold">New block</h2>
        <textarea
            name="text"
            placeholder="What's on your mind?"
            class="w-full border rounded-md p-3"
            bind:value={blockText}
        />
        <Button>Save</Button>
    </form>
</div>
