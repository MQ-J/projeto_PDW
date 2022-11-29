<script>
    import { listMenus } from "../services/menu.service";
</script>

<nav>
    <u>
        {#await listMenus()}
            Loading menu...
        {:then menuItems}
            {#each menuItems.data as menuItem}
                <li>{menuItem.name}</li>
            {/each}
        {/await}
    </u>
</nav>
