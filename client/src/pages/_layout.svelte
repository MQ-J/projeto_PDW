<!-- routify:options preload="proximity" -->
<script>
    import { url } from "@roxi/routify";
    import { afterUpdate } from "svelte"
    import { getAuthedUser, unauth } from "../services/auth.service";
    import Button from "../components/Button.svelte"


    let authedUser = getAuthedUser();

    afterUpdate(() => {authedUser = getAuthedUser()})
</script>

<div class="container sm">
    {#if typeof authedUser !== "undefined"}
        <header class="w-20">
            <a href={$url("/auth")} on:click={unauth}><Button inverted={true}>Sign out</Button></a>
        </header>
    {/if}
    <slot />
</div>
