<template>
    <div class="size-header">

        <h4 class="">尺码定义</h4>

        <el-row :gutter="20">
            <el-col :span="4">value</el-col>
            <el-col :span="4">label</el-col>
            <el-col :span="4">语言</el-col>
            <el-col :span="4">是否必填</el-col>
        </el-row>


        <el-row :gutter="20" v-for="(item ,index) in sizeHeaderForm.rows" :key="index">

            <el-col :span="4">
                <el-input size="small" v-model="item.value"></el-input>
                <input type="hidden" :name="'value_'+index"  required v-model="item.value">
            </el-col>

            <el-col :span="4">
                <el-input size="small" v-model="item.label"></el-input>
                <input type="hidden"  :name="'label_'+index" required v-model="item.label">
            </el-col>

            <el-col :span="4">
                <el-select size="small" v-model="item.locale">
                    <el-option v-for="(lang,key) in JSON.parse(langs)" :key="key" :label="item.name" :value="key"></el-option>
                </el-select>
                <input type="hidden"  :name="'locale_'+index" required v-model="item.locale">
            </el-col>

            <el-col :span="4">
                <el-checkbox v-model="item.isMust"></el-checkbox>
            </el-col>

            <el-col :span="4">
                <el-button @click="remove(item)" size="small" type="danger" icon="el-icon-delete" circle></el-button>
            </el-col>

        </el-row>

        <el-row :gutter="20" class="text-center">
            <el-col :span="16">
                <el-button class="btn-long" size="small" @click="addrow">新增</el-button>
            </el-col>
        </el-row>

        <input type="hidden" name="size_headers" v-model="sizeheaderValue">

    </div>
</template>
<style>
.size-header{padding:20px;}
.btn-long{width:100%;border:1px dashed #ddd;}
</style>
<script type="application/javascript">
    export default{
        name:'SizeHeader',
        props:['langs','sizeHeaderFormValues'],
        computed:{
            sizeheaderValue:function(){
                return JSON.stringify(this.sizeHeaderForm.rows)
            }
        },
        data(){
            return {
                sizeHeaderForm:{
                    rows:[
                        { value:'' , label:'' , locale:'',isMust:false }
                    ]
                }
            }
        },

        methods:{
            addrow:function(){
                this.sizeHeaderForm.rows.push({
                    value:'',
                    locale:'',
                    isMust:''
                })
            },
            remove:function(item){
                var index = this.sizeHeaderForm.rows.indexOf(item)
                if (index !== -1) {
                    this.sizeHeaderForm.rows.splice(index, 1)
                }
            }
        },
        mounted(){
            if( !!this.sizeHeaderFormValues ){
                this.sizeHeaderForm.rows = JSON.parse(this.sizeHeaderFormValues)
            }
        }
    }
</script>