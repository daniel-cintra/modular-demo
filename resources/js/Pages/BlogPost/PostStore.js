import { defineStore } from 'pinia'

export const usePostStore = defineStore('PostStore', {
    state: () => {
        return {
            post: {
                title: '',
                content: '',
                image: null,

                meta_tag_title: '',
                meta_tag_description: '',

                remove_previous_image: false
            }
        }
    },

    actions: {
        setPost(post) {
            this.post = post
        },
        update(key, value) {
            this.post[key] = value
        }
    }
})
