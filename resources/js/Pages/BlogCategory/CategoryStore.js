import { defineStore } from 'pinia'
import slug from '@resources/js/Utils/slug.js'

export const useCategoryStore = defineStore('CategoryStore', {
    state: () => {
        return {
            category: {
                name: '',
                description: '',
                image: null,

                is_visible: false,

                meta_tag_title: '',
                meta_tag_description: '',

                remove_previous_image: false
            }
        }
    },

    actions: {
        setCategory(category) {
            this.category = category
        },
        initSeoTags() {
            this.category.meta_tag_title = this.category.name.substring(0, 60)
            this.category.meta_tag_description =
                this.category.description.replace(/<\/?[^>]+(>|$)/g, '')
        }
    },

    getters: {
        getRemainingChars: (state) => {
            return (key, max) => {
                if (!state.category[key]) return max

                return max - state.category[key].length
            }
        },

        showSeoAlert: (state) => {
            return () => {
                if (
                    state.category.meta_tag_title &&
                    state.category.meta_tag_title.length
                ) {
                    return false
                }

                if (
                    state.category.name.length > 1 &&
                    state.category.description.length > 2
                ) {
                    return false
                }

                return true
            }
        },

        getSlug: (state) => {
            return () => {
                if (!state.category.name) return ''

                return slug(state.category.name)
            }
        }
    }
})
