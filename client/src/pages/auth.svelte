<script>
    import { createUser } from "../services/user.service";
    import { getToken, getAuthedUser } from "../services/auth.service";
    import { redirect } from "@roxi/routify";
    let signedUp = false;
    let failedSignUp = false;

    let signedIn = false;
    let failedSignIn = false;
    let showSlotContent = false;

    if (typeof getAuthedUser() !== "undefined") $redirect("/");
    else showSlotContent = true;

    function handleSignUp(e) {
        e.preventDefault();
        const target = e.target;
        createUser(target.username.value, target.email.value, target.pwd.value)
            .then(() => {
                signedUp = true;
                e.target.reset();
            })
            .catch((e) => {
                failedSignUp = true;
            });
    }

    function handleSignIn(e) {
        e.preventDefault();
        const target = e.target;
        getToken(target.username.value, target.pwd.value)
            .then((r) => {
                localStorage.setItem(
                    "auth",
                    JSON.stringify({ token: r.data.token })
                );
                signedIn = true;
                // e.target.reset()
            })
            .catch((e) => {
                console.log(e);
                failedSignIn = true;
                // e.target.reset()
            });
    }
</script>
{#if showSlotContent}
    <div class="flex m-auto w-2/3">
        <form class="flex-1 w-1/2 p-10" on:submit={handleSignIn}>
            <h2 class="text-xl">Sign in</h2>
            <label for="username" class="block">Username</label>
            <input
                required
                type="text"
                name="username"
                id="username"
                class="rounded-md border border-gray-20 py-1 w-full bg-gray-50"
            />
            <label for="pwd" class="block">Password</label>
            <input
                required
                type="password"
                id="pwd"
                class="rounded-md border border-gray-20 py-1 w-full bg-gray-50"
                name="pwd"
            />
            <button
                class="block bg-blue-500 rounded-md text-white mt-2 py-2 w-full"
                >Sign in</button
            >
            {#if signedIn}
                <div class="text-green-900 p-1 my-1">
                    Authentication successful
                </div>
            {/if}
            {#if failedSignIn}
                <div class="text-red-900 p-1 my-1">Authentication failed</div>
            {/if}
        </form>
        <form class="flex-2 w-1/2 p-10" on:submit={handleSignUp}>
            <h2 class="text-xl">Sign up</h2>
            <label for="username_up" class="block">Username</label>
            <input
                required
                type="text"
                name="username"
                value="henrique"
                id="username_up"
                class="rounded-md border border-gray-20 py-1 w-full bg-gray-50"
            />
            <label for="email_up" class="block">Email</label>
            <input
                required
                value="henrique@email.com"
                type="email"
                name="email"
                id="email_up"
                class="rounded-md border border-gray-20 py-1 w-full bg-gray-50"
            />
            <label for="pwd_up" class="block">Password</label>
            <input
                required
                value="123"
                type="password"
                name="pwd"
                id="pwd_up"
                class="rounded-md border border-gray-20 py-1 w-full bg-gray-50"
            />
            <button
                class="block bg-blue-500 rounded-md text-white mt-2 py-2 w-full"
                >Sign up</button
            >
            {#if signedUp}
                <div class="text-green-900 p-1 my-1">
                    Registration successful
                </div>
            {/if}
            {#if failedSignUp}
                <div class="text-red-900 p-1 my-1">Registration failed</div>
            {/if}
        </form>
    </div>
{/if}

<style>
    input {
        margin-bottom: 10px;
    }
    h2 {
        font-weight: bold;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
</style>
