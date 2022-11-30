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

    $: hasPermalink = permalink.length > 0

    $: blocks = listBlocks(permalink);

    menuPermalink.subscribe((value) => {
        permalink = value;
    });

    function refreshBlocks() {
        blocks = listBlocks(permalink);
    }

    let blockText = "";
    let blockId = -1;

    function handleBlockForm(e) {
        e.preventDefault();
        const target = e.target;
        if (blockText.length > 0 && blockId != -1) {
            updateBlocks(permalink, blockId, blockText).then(() => {
                blockText = "";
                blockId = -1;
                refreshBlocks()
            });
        } else {
            createBlocks(permalink, target.text.value).then(refreshBlocks);
            blockId = -1;
            blockText = "";
        }
    }

    function edit(block) {
        blockText = block.text;
        blockId = block.id;
    }
</script>

<Menu />
<div style="width: 400px">
    {#await blocks}
        Loading blocks
    {:then blockItems}
        {#if blockItems.data.length > 0}
            <p>Click on a block to select it for edition.</p>
        {/if}
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
            
        <form on:submit={handleBlockForm} class="border p-2 my-2" >
        <h2 class="text-lg font-bold">New block</h2>
        <textarea
            name="text"
            placeholder="What's on your mind?"
            class="w-full border rounded-md p-3"
            bind:value={blockText}
            disabled={!hasPermalink}
        />
        <Button disabled={!hasPermalink }>Save</Button>
    </form>
</div>
