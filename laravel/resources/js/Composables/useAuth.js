import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const user = ref(null)
const loading = ref(true)

export const useAuth = () => {

    const fetchUser = async () => {
        const token = localStorage.getItem('token')

        if (!token) {
            user.value = null
            loading.value = false
            return
        }

        try {
            const res = await axios.get('/api/profile', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })

            user.value = res.data.user ?? res.data

        } catch (e) {
            user.value = null
            localStorage.removeItem('token')
        } finally {
            loading.value = false
        }
    }

    onMounted(() => {
        fetchUser()
    })

    const isAuth = computed(() => !!user.value)
    const isAdmin = computed(() => user.value?.role === 'admin')

    return {
        user,
        loading,
        isAuth,
        isAdmin,
        fetchUser
    }
}