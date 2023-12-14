import { ZiggyVue } from '/vendor/tightenco/ziggy/dist/vue.m'

export default {
    // main navigation - side menu
    items: [
        {
            label: 'Dashboard',
            permission: 'Dashboard',
            icon: 'ri-dashboard-line',
            link: route('dashboard.index')
        },

        {
            label: 'Blog',
            permission: 'Blog',
            children: [
                {
                    label: 'Posts',
                    permission: 'Blog: Post - List',
                    icon: 'ri-draft-line',
                    link: route('blogPost.index')
                },
                {
                    label: 'Categories',
                    permission: 'Blog: Category - List',
                    icon: 'ri-folders-line',
                    link: route('blogCategory.index')
                },
                {
                    label: 'Authors',
                    permission: 'Blog: Author - List',
                    icon: 'ri-team-line',
                    link: route('blogAuthor.index')
                }
            ]
        },

        {
            label: 'Access Control List',
            permission: 'ACL',
            children: [
                {
                    label: 'Users',
                    permission: 'Acl: User - List',
                    icon: 'ri-user-line',
                    link: route('user.index')
                },
                {
                    label: 'Permissions',
                    permission: 'Acl: Permission - List',
                    icon: 'ri-shield-keyhole-line',
                    link: route('aclPermission.index')
                },
                {
                    label: 'Roles',
                    permission: 'Acl: Role - List',
                    icon: 'ri-account-box-line',
                    link: route('aclRole.index')
                }
            ]
        }
    ]
}
