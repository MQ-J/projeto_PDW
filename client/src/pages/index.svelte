<script>
    import Menu from "../components/Menu.svelte";
    import { menuPermalink } from "../store.js";
    import { afterUpdate } from "svelte";
    import {listBlocks, createBlocks} from "../services/block.service"

    let permalink;

    let blocks = listBlocks(permalink)

    menuPermalink.subscribe((value) => {
        permalink = value;
    });

    afterUpdate(() => {
        blocks = listBlocks(permalink)
    });

    function handleBlockForm(e){
        e.preventDefault();
        const target = e.target
        createBlocks(permalink, target.text.value)
    }
</script>

{permalink}

<Menu />

{#await blocks}
    Loading blocks
{:then blockItems} 
{#each blockItems.data as block}
    { block.text }
{/each}
{/await}
<form on:submit={handleBlockForm}>
    <textarea name="text" placeholder="What's on your mind?"></textarea>
    <button>Save</button>
</form>