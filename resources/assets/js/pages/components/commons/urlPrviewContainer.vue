<style>

    div.urlPreviewContainer {
        max-height: 150px;
        color:black;
    }

    div.urlPreviewContainer div.urlPreviewTitle {
        font-size: 16px;
        margin-top: 0;
    }

    div.urlPreviewContainer div.urlPreviewDescription {
        font-size: 10px;
    }
</style>
<template>
    <div class="urlPreviewContainer">
        <a :href="urlPreview.url">
            <div class="row">
                <div class="col-xs-3">
                    <img :src="urlPreview.imageSrc" class="img-responsive" alt="">
                </div>
                <div class="col-xs-9">
                    <p class="urlPreviewTitle">{{urlPreview.title}}</p>
                    <p class="urlPreviewDescription">{{urlPreview.description}}</p>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    export default{
        props: {
            urlPreview: {
                type: Object
            }
        }
    }
</script>