<template>
    <div class="view-selector">
        <button 
            v-for="currentView in views" 
            :key="currentView"
            @click="$emit('view-select', currentView)"
            :class="`cms-btn ${currentView === view ? 'active' : ''}`">{{ currentView }}</button>
    </div>
</template>

<script>
export default {
    name: "ViewSelector",
    props: {
        views: Array,
        view: String
    }
}
</script>

<style lang="scss" scoped>
    .cms-btn {
        margin-right: 8px;
    }

    .view-selector {
        margin-bottom: 16px;
    }
</style>