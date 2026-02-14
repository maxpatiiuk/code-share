export interface RuleNode {
  path: string;
  leaf?: string;
  children?: Record<string, RuleNode>;
}

export interface Result {
  labelParts: string[];
  url: string;
  branches: RuleNode['children'];
}
