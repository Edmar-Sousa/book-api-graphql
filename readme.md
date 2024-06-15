# API de Livros em GraphQL

## Queries

1. **getBook**
   - **Descrição:** Retorna informações de um livro específico com base no ID fornecido.
   - **Argumentos:** `id: ID!`

2. **listBooks**
   - **Descrição:** Retorna uma lista de todos os livros disponíveis na biblioteca.
   - **Argumentos:** Nenhum

3. **searchBooks**
   - **Descrição:** Retorna uma lista de livros que correspondem a um termo de busca no título, autor ou descrição.
   - **Argumentos:** `query: String!`

4. **getAuthor**
   - **Descrição:** Retorna informações de um autor específico com base no ID fornecido.
   - **Argumentos:** `id: ID!`

5. **listAuthors**
   - **Descrição:** Retorna uma lista de todos os autores disponíveis na biblioteca.
   - **Argumentos:** Nenhum

6. **getCategory**
   - **Descrição:** Retorna informações de uma categoria específica com base no ID fornecido.
   - **Argumentos:** `id: ID!`

7. **listCategories**
   - **Descrição:** Retorna uma lista de todas as categorias disponíveis na biblioteca.
   - **Argumentos:** Nenhum

## Mutations

1. **addBook**
   - **Descrição:** Adiciona um novo livro à biblioteca.
   - **Argumentos:** 
     - `title: String!`
     - `authorId: ID!`
     - `categoryIds: [ID!]!`
     - `description: String`
     - `publishedYear: Int`

2. **updateBook**
   - **Descrição:** Atualiza as informações de um livro existente.
   - **Argumentos:** 
     - `id: ID!`
     - `title: String`
     - `authorId: ID`
     - `categoryIds: [ID!]`
     - `description: String`
     - `publishedYear: Int`

3. **deleteBook**
   - **Descrição:** Remove um livro da biblioteca com base no ID fornecido.
   - **Argumentos:** `id: ID!`

4. **addAuthor**
   - **Descrição:** Adiciona um novo autor à biblioteca.
   - **Argumentos:** 
     - `name: String!`
     - `bio: String`

5. **updateAuthor**
   - **Descrição:** Atualiza as informações de um autor existente.
   - **Argumentos:** 
     - `id: ID!`
     - `name: String`
     - `bio: String`

6. **deleteAuthor**
   - **Descrição:** Remove um autor da biblioteca com base no ID fornecido.
   - **Argumentos:** `id: ID!`

7. **addCategory**
   - **Descrição:** Adiciona uma nova categoria à biblioteca.
   - **Argumentos:** `name: String!`

8. **updateCategory**
   - **Descrição:** Atualiza as informações de uma categoria existente.
   - **Argumentos:** 
     - `id: ID!`
     - `name: String`

9. **deleteCategory**
   - **Descrição:** Remove uma categoria da biblioteca com base no ID fornecido.
   - **Argumentos:** `id: ID!`
