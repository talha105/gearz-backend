<template>
    <div class="flex-wrap align-content-center d-flex h-100 justify-content-center">
        <div
            class="item-pill"
            v-for="(item, index) in items" :key="index"
            :class="[{'selected': value.includes(item.id)},variant]"
            @click="selectedItem(item.id)">
            {{ item[label] }}
        </div>
        <template v-if="!readonly">
            <div
                v-if="value.length != items.length"
                class="item-pill"
                :class="[{'selected': value.length == items.length},variant]"
                @click="selectAllItems"> Select All
            </div>
            <div
                v-if="value.length == items.length"
                class="item-pill"
                :class="[variant]"
                @click="deselectAllItems"> Deselect All
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        items: {
            type: Array,
            default: () => []
        },
        value: {
            type: Array,
            default: () => []
        },
        label: {
            type: String,
            default: 'title'
        },
        variant: {
            type: String,
            default: 'black'
        },
        selectAll: {
            type: Boolean,
            default: false
        },
        readonly: {
            type: Boolean,
            default: false
        }
    },
    methods:{
        selectedItem(item) {
            if(!this.readonly) {
                if(!this.value.includes(item)) {
                    let items = [...this.value, item];
                    this.$emit('input', items)
                }else{
                    let items = this.value.filter(obj => obj !== item)
                    this.$emit('input', items)
                }
            }
        },
        selectAllItems() {
            let items = this.value;
            this.items.map( pill => {
                if(!this.value.includes(pill.id)) {
                    items.push(pill.id)
                }
            })
            this.$emit('input', items)
        },
        deselectAllItems() {
            this.$emit('input', [])
        }
    }
}
</script>

<style>
.item-pill.black.selected {
  background-color: #000000 !important;
  color: white !important;
}

.item-pill.black:hover {
  border-color: #000000;
  background-color: #00000026;
  color: #000000;
}

.item-pill.black {
  color: #000000;
  border: 1px solid #000000;
}




.item-pill.blue.selected {
  background-color: #1266f1 !important;
  color: white !important;
}

.item-pill.blue:hover {
  border-color: #1266f1;
  background-color: #1266f126;
  color: #1266f1;
}

.item-pill.blue {
  color: #1266f1;
  border: 1px solid #1266f1;
}




.item-pill.green.selected {
  background-color: #26a69a !important;
  color: white !important;
}

.item-pill.green:hover {
  border-color: #26a69a;
  background-color: #26a69a26;
  color: #26a69a;
}

.item-pill.green {
  color: #26a69a;
  border: 1px solid #26a69a;
}





.item-pill.orange.selected {
  background-color: #fb8c00 !important;
  color: white !important;
}

.item-pill.orange:hover {
  border-color: #fb8c00;
  background-color: #fb8c0026;
  color: #fb8c00;
}

.item-pill.orange {
  color: #fb8c00;
  border: 1px solid #fb8c00;
}



.item-pill {
  background-color: #ffffff;
  padding: 1px 14px;
  border-radius: 50px;
  margin-right: 9px;
  cursor: pointer;
  margin-bottom: 9px;
  transition: all 0.1s ease-in-out;
}
</style>

<!-- <style>
.item-pill.selected {
  /* background-color: #f93154; */
  background-color: #26a69a !important;
  /* background-color: #00b74a; */
  color: white !important;
}
.item-pill:hover {
  border-color: #1266f1;
  background-color: #0062ff26;
  color: #1266f1;
}
.item-pill {
  /* color: #f93154; */
  color: #26a69a;
  /* color: #00b74a; */
  /* border: 1px solid #f93154; */
  border: 1px solid #26a69a;
  /* border: 1px solid #00b74a; */
  background-color: #ffffff;
  padding: 1px 14px;
  border-radius: 50px;
  margin-right: 9px;
  cursor: pointer;
  margin-bottom: 9px;
  transition: all 0.1s ease-in-out;
}
</style> -->
