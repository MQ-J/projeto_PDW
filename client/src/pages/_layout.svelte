<!-- routify:options preload="proximity" -->
<script>
    import { url } from "@roxi/routify";
    import { getAuthedUser, unauth } from "../services/auth.service";
    const authedUser = getAuthedUser();
</script>

<div class="container sm">
    {#if typeof authedUser !== "undefined"}
        <header>
            <a href={$url("/auth")} on:click={unauth}>Sign out</a>
        </header>
    {/if}
    <slot />
</div>
