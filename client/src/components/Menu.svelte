<script>
    import { listMenus, createMenus } from "../services/menu.service";
    import { afterUpdate } from "svelte";

    import { menuPermalink } from '../store';
    import Button from "./Button.svelte";

    function setMenu(permalink){
        menuPermalink.update(() => permalink)
    }

    let menuList = listMenus();

    function refreshMenus() {
        menuList = listMenus();
    }

    afterUpdate(refreshMenus);
    
</script>
<nav>
    <u>
        {#await menuList}
            Loading menu...
        {:then menuItems}
            <span style="display: none">{setMenu(menuItems.data[0].permalink)}</span>

            {#each menuItems.data as menuItem}
                <li class="inline-block"><button on:click={() => setMenu(menuItem.permalink)} class="bg-black text-white mr-1 p-1 rounded-md">{menuItem.name}</button></li>
            {/each}
        {/await}
    </u>
    <form on:submit={(e) => {e.preventDefault(); createMenus(e.target.name.value).then(refreshMenus); e.target.name.value=''}}>
        <h2>New menu item</h2>
        <input type="text" name="name" class="border p-1 rounded-md" placeholder="Name of the new menu..." >
        <div  style="width: 50px"><Button>Save</Button></div>
    </form>
</nav>
