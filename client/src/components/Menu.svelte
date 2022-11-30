<script>
    import { listMenus } from "../services/menu.service";

    import { menuPermalink } from '../store';

    function setMenu(permalink){
        menuPermalink.update(() => permalink)
    }
</script>
<nav>
    <u>
        {#await listMenus()}
            Loading menu...
        {:then menuItems}
            <span style="display: none">{setMenu(menuItems.data[0].permalink)}</span>

            {#each menuItems.data as menuItem}
                <li class="inline-block"><button on:click={() => setMenu(menuItem.permalink)} class="bg-black text-white mr-1 p-1 rounded-md">{menuItem.name}</button></li>
            {/each}
        {/await}
    </u>
</nav>
