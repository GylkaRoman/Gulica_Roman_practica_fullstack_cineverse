export const api = async (url, options = {}) => {
    const token = localStorage.getItem('token')

    const res = await fetch(url, {
        method: options.method || 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token ? { Authorization: `Bearer ${token}` } : {})
        },
        body: options.body || null
    })

    const text = await res.text()

    let data
    try {
        data = text ? JSON.parse(text) : null
    } catch {
        throw new Error('Server did not return JSON')
    }

    if (!res.ok) {
        throw data
    }

    return data
}