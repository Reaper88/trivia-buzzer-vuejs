<template>
    <div class="app">
        <AppHeader fixed>
            <SidebarToggler class="d-lg-none" display="md" mobile />
            <b-link class="navbar-brand" to="/admin">
                <img class="navbar-brand-full" src="../../assets/img/logo.png" width="45" height="45" alt="Buzzer Logo" />
            </b-link>
            <SidebarToggler class="d-md-down-none" display="lg" />
            <b-navbar-nav class="ml-auto">
                <DefaultHeaderDropdownAccnt/>
            </b-navbar-nav>
        </AppHeader>
        <div class="app-body">
            <AppSidebar fixed>   
                <SidebarNav :navItems="nav"></SidebarNav>
                <SidebarMinimizer/>
            </AppSidebar>
            <main class="main">
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </main>
        </div>
        <TheFooter>
            <!--footer-->
            <div>
                <span class="ml-1">&copy; 2019 RayTech Hosting</span>
            </div>
            <div class="ml-auto">
                <span class="mr-1">Powered by</span>
                <a href="https://myraytech.net">RayTech Hosting</a>
            </div>
        </TheFooter>
    </div>
</template>

<script>
    import nav from '../_nav'
            import { Header as AppHeader, SidebarToggler, Sidebar as AppSidebar, SidebarFooter, SidebarForm, SidebarHeader, SidebarMinimizer, SidebarNav, Aside as AppAside, AsideToggler, Footer as TheFooter, Breadcrumb } from '@coreui/vue'
            import DefaultAside from './DefaultAside'
            import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'

            export default {
                name: 'DefaultContainer',
                components: {
                    AsideToggler,
                    AppHeader,
                    AppSidebar,
                    AppAside,
                    TheFooter,
                    Breadcrumb,
                    DefaultAside,
                    DefaultHeaderDropdownAccnt,
                    SidebarForm,
                    SidebarFooter,
                    SidebarToggler,
                    SidebarHeader,
                    SidebarNav,
                    SidebarMinimizer
                },
                data() {
                    return {
                        nav: nav.items
                    }
                },
                computed: {
                    name() {
                        return this.$route.name
                    }
                }
            }
</script>

<style lang="scss">
    // CoreUI Icons Set
    @import '~@coreui/icons/css/coreui-icons.min.css';
    /* Import Font Awesome Icons Set */
    $fa-font-path: '~font-awesome/fonts/';
    @import '~font-awesome/scss/font-awesome.scss';
    /* Import Simple Line Icons Set */
    $simple-line-font-path: '~simple-line-icons/fonts/';
    @import '~simple-line-icons/scss/simple-line-icons.scss';
    /* Import Flag Icons Set */
    @import '~flag-icon-css/css/flag-icon.min.css';
    /* Import Bootstrap Vue Styles */
    @import '~bootstrap-vue/dist/bootstrap-vue.css';
    // Import Main styles for this application
    @import '../assets/scss/style';
</style>