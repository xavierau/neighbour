<style></style>
<template>
    <div id="image-carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators" v-show="images.length>1">
            <li data-target="#image-carousel"
                data-slide-to="$index"
                :class="{'active':$index==activeItemIndex}"
                v-for="image in images"
            ></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item" :class="{'active':$index==activeItemIndex}"  v-for="image in images">
                <img :src="image.link" alt="">
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#image-carousel" role="button" data-slide="prev" v-show="images.length>1">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#image-carousel" role="button" data-slide="next" v-show="images.length>1">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</template>

<script>
    export default{
        props:{
            images:{
                type:Array,
                required:true
            },
            activeItemIndex:{
                type:Number,
                default:0
            }
        }
    }
</script>