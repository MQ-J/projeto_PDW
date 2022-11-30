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
            {#each menuItems.data as menuItem}
                <li><button on:click={() => setMenu(menuItem.permalink)} class="bg-blue-10">{menuItem.name}</button></li>
            {/each}
        {/await}
    </u>
</nav>
