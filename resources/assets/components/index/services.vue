<template>
  <v-app>

    <!-- Шапка сайта -->
    <app_bar :user_id="user_id" />

    <!-- ОСНОВНАЯ ЧАСТЬ -->
    <v-main>

      <!-- ТОП БАННЕР -->
      <v-card
              class="flex"
              flat
              tile
              dark
              app
              color="#456018"
      >
        <img class='img-responsive' src="/img/custom/bg01.jpg" style="margin-bottom: -25px;">
        <v-container fluid grid-list-lg>


          <v-layout row wrap>
            <v-flex xs12>

              <template>
                <v-flex xs12>
                  <!-- ЗАГОЛОВОК -->
                  <v-card color="transparent" flat class="my-3">
                    <v-card-subtitle class="pb-0">
                      <h1 class="my-0 display-1" style="color:#fff;">Услуги</h1>
                    </v-card-subtitle>
                  </v-card>
                </v-flex>
              </template>

            </v-flex>

          </v-layout>

        </v-container>
      </v-card>
      <v-container fluid grid-list-lg>

        <<!--v-layout row wrap>
          <v-flex xs12>
            <template>

              <v-flex xs12>
                <v-card color="transparent" flat class="my-3">
                  <v-card-title>
                    <h1 class="my-0 display-1" style="color:#465F1E;">Агрономическое сопровождение</h1>
                  </v-card-title>
                </v-card>
              </v-flex>

            </template>
          </v-flex>
        </v-layout>-->




        <v-layout row wrap>
          <v-flex xs12>
            <template>
              <v-flex xs12>
                <v-card color="transparent" flat class="my-3">
                  <v-card-title>
                    <h2 class="display-1">Агрономическое сопровождение: кому и зачем необходимо</h2>
                  </v-card-title>
                  <v-card-subtitle>



<p>
                      С каждым годом появляется немало начинающих аграриев и фермеров, желающих построить бизнес на выращивании сельскохозяйственных культур. Однако, не имея в этом опыта, можно потерять все вложения или остаться без хорошего урожая. Нюансы заключаются не только в закупках техники, удобрений, химикатов и прочих необходимых товаров, но и на каждом этапе возделывания земли. Именно поэтому следует воспользоваться консультацией агронома, который сможет объяснить, как выгодно вложить свои средства и собрать в результате хороший урожай.
                      </p>


<p>Агрономическое сопровождение – это всесторонние консультации специалистов на каждом этапе сельскохозяйственной деятельности. Помощь опытного агронома позволит избежать многих ошибок во время обработки почвы, процесса посева, внесения удобрений и химикатов, а также сбора урожая. Специалист поможет разобраться в том, какие культуры стоит засевать и в каком порядке, чтобы не истощать почву и сохранять ее плодовитость. Также он подскажет, как в соответствии с климатом в вашем регионе получить хороший сбор.</p>

<p>Благодаря этому, вы сможете наладить свой бизнес и окупить все вложения. Стоит отметить, что это выгодно не только для фермеров-новичков. Многие опытные земледельцы также нередко сталкиваются с проблемными задачами, которые требуют решения. Именно в таких случаях им может пригодиться взгляд и оценка специалиста. Экономия на этих услугах может обернуться крупной потерей средств из-за неразумного использования земли и организации посева.</p>

<p>Также помощь специалиста может потребоваться и тем, кто занимается садоводством. Консультация агронома-садовода может дать ответы на многие вопросы об особенностях выращивания фруктовых деревьев, ухода за ними, выведении новых сортов и многое другое.
Как и где получить консультацию агронома-специалиста?</p>

<p>Консультацию можно получить несколькими способами. Во-первых, можно найти аграрную компанию или агентство, которые предоставляют подобные услуги. Однако не в каждом регионе есть подобные специалисты. Во-вторых, можно получить помощь агронома онлайн. Существует довольно много ресурсов, которые предлагают удаленные консультации на постоянной основе.</p>






                  </v-card-subtitle>
                </v-card>
              </v-flex>
            </template>
          </v-flex>
        </v-layout>





        <v-layout row wrap>
          <v-flex xs12>
            <template>
              <v-flex xs12>
                <v-card color="transparent" flat class="my-3">
                  <v-card-title>
                    <h2 class="display-1">Также можно нанять консультанта, который будет оказывать поддержку на всех этапах сельскохозяйственных работ. Отметим, что важно тщательно выбирать специалиста. Для этого пользуйтесь несколькими правилами:</h2>
                  </v-card-title>
                  <v-card-subtitle>



                    <ul>
                      <li> проверьте наличие высшего образования специалиста в данной отрасли;</li>
<li> поинтересуйтесь опытом работы;</li>
<li> проверьте его ориентированность в интересующих вопросах</li>
<li> уточните условия сотрудничества и способ оплаты.</li>                     
                    </ul>





                  </v-card-subtitle>
                </v-card>
              </v-flex>
            </template>
          </v-flex>
        </v-layout>


        <v-layout row wrap>
          <v-flex xs12>
            <template>
              <v-flex xs12>
                <v-card color="transparent" flat class="m2y-3">
                  <v-card-title>
                    <h2 class="display-1">Консультация агронома онлайн: в чем преимущества</h2>
                  </v-card-title>
                  <v-card-subtitle>
                    <p>Онлайн-консультации имеют множество преимуществ. Прежде всего, не нужно искать способ встретиться, а местоположение не имеет значения. Находясь удаленно, можно в любой момент решить все необходимые вопросы и поддерживать связь в любое время.
Также выбор онлайн-консультаций настолько большой, что можно выбрать понравившегося специалисты из любого региона.
Кроме того, стоимость онлайн-услуг сравнительно дешевле. Однако следует тщательно проверять сервисы, на которых предлагаются консультации. Важно, чтобы на сайте были отзывы, с помощью которых можно посмотреть реальную оценку услуг компании. Также не стоит обращаться к сомнительным сервисам, о которых мало информации и нет данных о регистрации. Соблюдая эти простые правила, можно получить помощь без рисков наткнуться на мошенников.</p>


<a href="#" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success" data-toggle="modal" data-target="#CallMe">
                        <span class="v-btn__content">Получить консультацию</span>
                    </a>



                  </v-card-subtitle>
                </v-card>
              </v-flex>
            </template>
          </v-flex>
        </v-layout>






        <v-divider class="my-0"></v-divider>
        <v-layout row wrap>
          <v-flex md6 xs12>
            <template>
              <v-flex xs12>
                <v-card color="transparent" flat class="my-3">
                  <v-card-title>
                    <i class="fa fa-gift" style="font-size: 64px; float: left; margin: 0 20px 0 0; color: #50AE55;"></i>
                    <h1 class="display-1" style="color:#465F1E;">Наша миссия</h1>
                  </v-card-title>
                  <v-card-subtitle class="pb-0">
                    <h4 style="color:#465F1E;">Повышение эффективности ведения бизнеса наших клиентов за счет внедрения
                      передовых управленческих технологий в области закупки
                      химических средств защиты растений</h4>
                  </v-card-subtitle>
                </v-card>
              </v-flex>
            </template>

          </v-flex>
          <v-flex md6 xs12>

            <template>
              <v-flex xs12>
                <v-card color="transparent" flat class="my-3">
                  <v-card-title>
                    <i class="fa fa-bullseye" style="font-size: 64px; float: left; margin: 0 20px 0 0; color: #50AE55;"></i>
                    <h1 class="display-1" style="color:#465F1E;">Наша цель</h1>
                  </v-card-title>
                  <v-card-subtitle class="pb-0">
                    <h4 style="color:#465F1E;">Оптимизация закупочной и сбытовой деятельности предприятий сельскохозяйственного
                      сектора Российской Федерации</h4>
                  </v-card-subtitle>
                </v-card>
              </v-flex>
            </template>
          </v-flex>
        </v-layout>
        <v-divider class="my-0"></v-divider>
        <br />



        <v-layout row wrap>
          <v-flex md12 xs12>
            <reviews_block />
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
    
    <!-- Подвал -->
    <footer_bar :user_id="user_id" />

  </v-app>
</template>

<script> 

import app_bar from './components/app_bar'
import footer_bar from './components/footer_bar'
import reviews_block from './components/reviews_block'

export default {
  name: 'about_service',
  data () {
    return {
    }
  },
  mounted() {
    
  },
  methods: {
  },
  props: {
    user_id: Number,
  },
  components: {
    app_bar,
    footer_bar,
    reviews_block,
  },
  computed: {
  },
};
</script>

<style>
.theme--light.v-data-table {
  background: transparent !important;
}
#main {
  background: #f1f1f1;
}
</style>
