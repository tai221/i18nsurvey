<template>
  <div :class="{'hidden':hidden}" class="pagination-container">
    <ElPagination
      :current-page.sync="currentPage"
      :page-size.sync="pageSize"
      :layout="layout"
      :total="total"
      v-bind="$attrs"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />
  </div>
</template>

<script>
import { scrollTo } from '../../utils/scrollTo'

export default {
  name: 'Pagination',
  props: {
    layout: {
      type: String,
      default: 'total, sizes, prev, pager, next, jumper'
    },
    background: {
      type: Boolean,
      default: true
    },
    autoScroll: {
      type: Boolean,
      default: false
    },
    hidden: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      total: 0,
      pageSize: 10,
      currentPage: 1
    }
  },
  methods: {
    handleSizeChange(val) {
      this.$emit('pagination', { page: this.currentPage, limit: val })
      if (this.autoScroll) {
        scrollTo(0, 800)
      }
    },
    handleCurrentChange(val) {
      this.$emit('pagination', { page: val, limit: this.pageSize })
      if (this.autoScroll) {
        scrollTo(0, 800)
      }
    },
    setPaginationData(data) {
      if (data) {
        this.currentPage = data.current_page
        this.pageSize = data.page_size
        this.total = data.total
      }
    }
  }
}
</script>

<style scoped>
.pagination-container {
  background: #fff;
  padding: 32px 16px;
}
.pagination-container.hidden {
  display: none;
}
</style>
