<template>
    <div class="autocomplete">
        <input type="text" :placeholder="placeHolderText" v-model="keywordSearch" class="form-textinput" :class="{ 'loading-circle' : (keywordSearch.length > 2), 'hide-loading-circle': resultItems.length > 0 || resultItems.length == 0 && !autoCompleteProgress  }" @keyup="!autoCompleteProgress ? onKeyUp(keywordSearch) : ''"/>
        <ul class="autocomplete-results" v-if="resultItems.length > 0">
            <li class="autocomplete-result" v-for="(item,i) in resultItems" :key="i" @click="keywordSearch='';onSelected(item[itemId], item[itemText])">
                {{ item[itemText] }}
            </li>
        </ul>
    </div>    
</template>

<script>
export default {
    props: {
        placeHolderText: String,
        onKeyUp: Function,
        onSelected: Function,
        resultItems: Array,
        autoCompleteProgress: Boolean,
        itemText: String,
        itemId: String
    },
    data() {
        return {
            keywordSearch: ''
        }
    },    
}
</script>