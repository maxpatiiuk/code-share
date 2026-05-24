Notes from https://anthropic.skilljar.com/ and manual research.

## High level

- Nothing beats experience. Experiment with it. Try out new features.
- Ask AI to write AI prompts.
- Hooks for things that must happen and must happen earlier than commit time,
  but they slow down the loop and can frustrate the agent
- Skills are on demand context - seems useful, except that it duplicates the
  human docs
- MCP - can teach agent to use the tools, or retrieve the docs.

## Prompt evaluation

- write a prompt
- run it on test data. can use llm to generate test cases and even description
  of how to evaluate the result
- use llm to grade the results - in grading prompt, ask model to first assess
  strength, weaknesses, and provide reasoning to help it reason through. if
  code, also check static analysis and test results. or grade manually

  For simple rating/classification tasks, letting the model talk is cheaper than
  using thinking models.

- compare the grades across prompts

## Prompt engineering

- Clear and direct, especially the first line of the prompt.
- Start with action verbs. Give instructions over asking questions.

  "Write three paragraphs about how solar panels work".

- Two approaches for constraining output:

  - Provide specific guidelines: length, what is expected, format, minimal
    requirements. Use this for most kind of prompts.

    Use positive over negative instructions. "Use active voice" over "Don't use
    passive voice"

  - Promise steps for the model (brainstorm ideas, pick the best, create
    outline, brainstorm supporting details, write the response). Use this only
    for prompts where need to force the model to consider more ideas than it
    naturally might. Do not use this for reasoning models as it interferes with
    their own thought process.

- For structured responses, preempt the agent with ` ```json `, or
  ` Here are three shell commands in one code block without any comments: ```sh  `.
- If injecting dynamic content into prompt, for multi-line content, wrap content
  in fake xml tags like `<my_code>`
- Provide examples of expected outputs. `<sample_input>`, `<sample_output>`. Eg,
  to detect tricky cases like sarcasm in sentiment analysis. Could use the
  highest rated outputs from the prompt evaluations as an example. Can also
  provide why the example is good.

## Tool use

Under the hood, tools are defined as JSON schema in system instructions.

The agent may respond with a tool call.

After the tool call, an API call is made again, appending all prior messages and
the tool call result - this relies on implicit prompt caching to reduce the
costs and latency.

Compared to implementing a tool call using a manual prompt:

- LLM is guaranteed to follow the schema
- LLM was trained on tool calling so it doesn't need to think about how to call
  it correctly

## RAG

Chunk text and create vectors for the chunks (embeddings). Chunking strategies:

- Fixed size, with a bit of overlap for context - simplest 80/20
- Chunk by sections - works if content has sections, though need to handle
  overly long sections
- Chunk by semantic similarity - use LLM to chunk text - more pricy, but more
  accurate

History:

- 1980-1990s - early grids based on text
- 2013 Google's World2Vec - vectors based on words
- 2018 Transformers - can differentiate between apple and Apple

Embedding miss out on precise terms. Full text search (BM25) is better for that.
RAG combines results from embeddings and full text search, and combines them by
scoring their rankings (RRF).

## Prompt caching

Gemini has implicit cache - if hits, 90% cost reduction on tokens. There is also
explicit cache, but that costs per hour cache storage. Cache lives in highly
limited GPU VRAM, or NVMe SSDs, so is pricy to store.

Cache works like docker layers - tools, system prompt, and instructions change
less and so are earlier in the stack.

## MCP

A protocol for extending agents.

Can provide tools, skills, resources, and prompts.

Can be run locally (sdtio) or on a remote server (http, web socket).

Stdio permits easy bi-directional communication. Http permits that using
streamable http, but there is overhead of initial handshake http requests and
harder horizontal sharding so Http mcp can be run in stateless mode (which
looses stream support). Server may need to initiate a communication to give a
progress update, logging, or call sampling.

Power feature:
[sampling](https://modelcontextprotocol.io/specification/2025-11-25/client/sampling)
allows MCP server to prompt the agent and get a response back, offloading the
cost of providing and configuring the LLM back to the client.

## Agents and workflows

Workflows - sequence of llm calls when the steps are known and we control the
flow. Can even call multiple agents in parallel for subtasks and aggregate
results. Higher accuracy and easier to evaluate, but far less flexible.

Agent - given a set of tools, the llm decides when to call which tools.
Flexible, but lower success rate (too much responsibility on the llm) and harder
to evaluate.
