<!-- routify:options preload="proximity" -->
<script>
    import { url } from "@roxi/routify";
    import { afterUpdate } from "svelte"
    import { getAuthedUser, unauth } from "../services/auth.service";

    let authedUser = getAuthedUser();

    afterUpdate(() => {authedUser = getAuthedUser()})
</script>

<div class="container sm">
    {#if typeof authedUser !== "undefined"}
        <header>
            <a href={$url("/auth")} on:click={unauth}>Sign out</a>
        </header>
    {/if}
    <slot />
</div>
