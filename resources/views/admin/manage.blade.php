@extends('layout.master')
@section('content')
<div class="fronds-row col-12">
    <nav class="fronds-left-nav col-2">
        @frondsMenu('actions')
            @frondsMenuItem('pages','Manage Pages')
            @frondsMenuItem('menus','Manage Menus')
            @frondsMenuItem('content','Manage Content')
            @frondsMenuItem('images','Manage Images')
            @frondsMenuItem('theme','Manage Theme')
        @endFrondsMenu
    </nav>
    <div class="fronds-content col-10">
        @frondsMenuContent('actions','pages', ['pageList' => $pageList])
        @frondsMenuContent('actions','menus', ['menuList' => $menuList])
        @frondsMenuContent('actions','content')
        @frondsMenuContent('actions','images')
        @frondsMenuContent('actions','theme')
    </div>
</div>
@stop

@push('theme_scripts')
    <script>
        // this is used to hook in to the fronds JS libraries after page load
        // the syntax is {theme name}Booted()
        function defaultBooted() {
            var menuManager = Fronds.getMenuManager();
            // when i click X display Y would be the way to read this
            menuManager.registerMenu("pages", "pages");
            menuManager.registerMenu("menus", "menus");
            menuManager.registerMenu("content", "content");
            menuManager.registerMenu("images", "images");
            menuManager.registerMenu("theme", "theme");
            menuManager.commit();
            // strips the hash off the front that location.hash likes to leave on
            const currentHash = location.hash;
            if (currentHash === "") {
                menuManager.showFromMenu("pages");
            } else {
                menuManager.showFromMenu(currentHash.substring(1));
            }
        }
    </script>
@endpush