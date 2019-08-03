<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Makaleler {{articles.length}}</div>

          <div class="card-body">
            <ul>
              <li v-for="article in articles">{{ article.title }}</li>
            </ul>
            <button
              v-if="nextPageUrl"
              class="btn btn-primary"
              @click.prevent="loadNextPage"
            >Devamını Yükle</button>
          </div>

          <div class="card-body" v-if="userApiToken">
            <form @submit.prevent="addArticle">
              <label for>Başlık</label>
              <input type="text" v-model="newArticleTitle" class="form-control" />
              <br />
              <label for>İçerik</label>
              <textarea v-model="newArticleContent" id cols="30" rows="10" class="form-control"></textarea>
              <br />
              <label for>Etiketler (virgülle ayır)</label>
              <input type="text" v-model="newArticleTags" class="form-control" />
              <br />
              <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newArticleTitle: null,
      newArticleContent: null,
      newArticleTags: null,
      articles: [],
      nextPageUrl: null
    };
  },
  methods: {
    addArticle: function() {
      axios
        .post("articles", {
          title: this.newArticleTitle,
          content: this.newArticleContent,
          tags: this.newArticleTags
        })
        .then(resp => {
          this.articles.push(resp.data);
        });
    },
    loadNextPage: function() {
      axios.get(this.nextPageUrl).then(response => {
        this.articles = [...this.articles, ...response.data.data];
        this.nextPageUrl = response.data.next_page_url;
      });
    }
  },
  computed: {
    userApiToken: function() {
      if (window.userApiToken) return window.userApiToken;
      return null;
    }
  },
  mounted() {
    axios.get("articles").then(response => {
      this.articles = response.data.data;
      this.nextPageUrl = response.data.next_page_url;
    });
  }
};
</script>
