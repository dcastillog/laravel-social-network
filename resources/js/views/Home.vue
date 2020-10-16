<template>
    <div>
        <div class="card border-0 bg-light mb-3 shadow-sm">
            <status-form />
        </div> 
        <status-list />
    </div>
</template>

<script>
    import StatusForm from '../components/StatusForm';
    import StatusList from '../components/StatusList';

    export default {
        components: {
            StatusList,
            StatusForm
        }
    }
</script>