<header>
    <nav class="bg-orange-100">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <div class="w-28">
                <img src="images/logo.png" href="">
            </div>
            <nav class="flex space-x-32">
                <a class="text-4xl" href="post.php">Last Posts</a>
                <a class="text-4xl" href="feed.php">My feed</a>
                <a class="text-4xl" href="">Events</a>
            </nav>
            <div class="relative group">
                <div
                    class="flex items-center cursor-pointer text-4xl group-hover:border-grey-light rounded-t-lg py-1 px-2 ">

                    My Profile
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
                <div
                    class="bg-yellow-100 items-center absolute border border-t-0 rounded-b-lg p-1 bg-white p-2 invisible group-hover:visible w-full">
                    <a href="profile.php" class="px-4 py-2 block text-black hover:bg-grey-lighter">View Profile</a>
                    <hr class="border-t mx-2 border-grey-ligght">
                    <a href="index.php" class="px-4 py-2 block text-black hover:bg-grey-lighter">Logout</a>
                </div>
            </div>
        </div>
    </nav>
</header>