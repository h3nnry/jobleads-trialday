<template>
  <div style="text-align: center;">
    <img src="hero.png" alt="SuperHugeHero" width="750" height="200" style="display: block; margin: 0 auto;" />
    <Tutorial style="text-align: left"/>
  </div>
</template>

<script>
import _ from 'lodash';
import moment from 'moment';
import heroimage from '/static/hero.png';

export default {
  name: 'IndexPage'
}
</script>

<style lang="scss">
@import 'fonts.scss';
@import 'index.scss';
</style>
