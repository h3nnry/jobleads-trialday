## JobLeads GridPathFinder Component
This is a Vue 3 application that includes a component named GridPathFinder. The component allows users to input a grid (as a 2D array of integers) and calculate the minimum cost path through the grid using a custom function.

## Problem
You are given a 2D grid of integers, where each cell represents a cost to move through that cell. Your taks is to update Vue3 composable in TypeScript to find the minimum cost of travel from the top-left corner to the bottom-right corner of the grid. You can only movie right or down

### Requirements
1. Extend Vue composable alghorithm that takes this 2D array as parameter,
2. The composable should return integer representing the minimum cost to travel

**Example 1**
Input: `[ [1,2,3], [4,5,6], [7,8,9] ]`
The path: `1 -> 2 -> 3 -> 6 -> 9`
Minimum cost: `21`

**Example 2**
Input: `[ [1,1,1], [1,1,1], [1,1,1] ]`
The path: `1 -> 1 -> 1 -> 1 -> 1`
Minimum cost: `5`

**Example 3**
Input: `[ [5,4,2], [1,9,3], [8,7,6] ]`
The path: `5 -> 4 -> 2 -> 3 -> 6`
Minimum cost: `5+4+2+3+6 = 20`

3. You are free to design the missing features of `GridPathFinder.vue`. Just make sure that:
A `textarea` takes as the input string of array of arrays, like in example. A button labeled `Update grid` is updating the table based on the input. A `table` displays the grid. A button called `Calucalte Minimum Cost` will use the minCostPath composable and calucalte the path. A `paragraph` will display the result (minimum cost)


### Project Structure
`./composables/useMinPath.js`
This file contains a composable function useMinCostPath. The minCostPath function should be implemented here, which takes a grid (2D array) as input and returns the minimum cost to traverse from the top-left corner to the bottom-right corner of the grid.


`/src/composables/useMinCostPath.ts`
```javascript
export function useMinCostPath() {
  function minCostPath(grid: number[][]): number {
    // Your function should be here
    return 1;
  }

  return { minCostPath };
}
```

`./components/GridPathFinder.vue`
This Vue component provides the UI for the user to interact with the grid and calculate the minimum cost path.

Template:
Textarea: Allows the user to input the grid as a 2D array of integers.
Update Grid Button: Updates the displayed grid in a table format based on the input.
Table: Displays the grid where each cell contains a number.
Calculate Minimum Cost Button: Triggers the calculation of the minimum cost path.
Paragraph: Displays the calculated minimum cost.

```vue
<template>
  <div>
    <textarea v-model="gridInput" placeholder="Enter grid as a 2D array"></textarea>
    <button @click="updateGrid">Update Grid</button>
    <table>
      <tr v-for="(row, rowIndex) in grid" :key="rowIndex">
        <td v-for="(cell, cellIndex) in row" :key="cellIndex">{{ cell }}</td>
      </tr>
    </table>
    <button @click="calculateMinCost">Calculate Minimum Cost</button>
    <p>Minimum Cost: {{ minCost }}</p>
  </div>
</template>
```
Script:
Refs:
gridInput (string): Stores the user input as a string.
grid (string): Stores the grid to be displayed in the table.
minCost (number): Stores the calculated minimum cost.
Methods:
updateGrid: Updates the grid display based on the user input.
calculateMinCost: Calculates the minimum cost path using the minCostPath function from useMinCostPath.

```typescript
<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'GridPathFinder',
  setup() {
    const gridInput = ref<string>();
    const grid = ref<string>();
    const minCost = ref<number>();

    const updateGrid = () => {
      // Action goes here
    };

    const calculateMinCost = () => {
      // Action goes here
    };

    return {
      gridInput,
      grid,
      minCost,
      updateGrid,
      calculateMinCost,
    };
  },
});
</script>
```


## Prerequisites

- Node.js v20.11.1
- npm v10.2.4

### Install dependencies

```bash
npm install
```

## Run the project

### Compiles and hot-reloads for development

```bash
npm run dev
```

### Compiles and minifies for production

```bash
npm run build
```

### Lints and fixes files

```bash
npm run lint
npm run lint:fix
```