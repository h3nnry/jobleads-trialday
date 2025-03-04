import { describe, it, expect } from 'vitest';
import { useMinCostPath } from '../composables/useMinCostPath';

describe('useMinCostPath', () => {
  const { minCostPath } = useMinCostPath();

  it('calculates the minimum cost path in a grid', () => {
    const grid = [
      [5, 4, 2],
      [1, 9, 3],
      [8, 7, 6]
    ];
    const result = minCostPath(grid);
    expect(result.cost).toBe(20);
  });
});
