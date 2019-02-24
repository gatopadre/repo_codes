// No editar
const teams = [
  { id: 1, country: 'Spain', name: 'Real Madrid C.F.' },
  { id: 2, country: 'Italy', name: 'A.C. Milan' },
  { id: 3, country: 'Spain', name: 'Futbol Club Barcelona' },
  { id: 4, country: 'Germany', name: 'FC Bayern Munich' },
  { id: 5, country: 'England', name: 'Liverpool F.C.' },
  { id: 6, country: 'Netherlands', name: 'AFC Ajax' },
  { id: 7, country: 'Italy', name: 'Inter Milan' },
  { id: 8, country: 'England', name: 'Manchester United F.C.' },
  { id: 9, country: 'England', name: 'Chelsea F.C.' },
  { id: 10, country: 'Portugal', name: 'FC Porto' },
  { id: 11, country: 'Germany', name: 'Borussia Dortmund' },
  { id: 12, country: 'Italy', name: 'Juventus FC' },
  { id: 13, country: 'France', name: 'Olympique Marseille' }

]

const leagues = [
  { id: 1, country: 'England', name: 'Premier League' },
  { id: 2, country: 'Germany', name: 'Bundesliga' },
  { id: 3, country: 'Netherlands', name: 'Eredivisie' },
  { id: 4, country: 'Spain', name: 'La Liga' },
  { id: 5, country: 'Italy', name: 'Serie A' },
  { id: 6, country: 'Portugal', name: 'Liga NOS' },
  { id: 7, country: 'France', name: 'Lige 1' }
]

const teamsByLeague = [
  { teamId: 12, leagueId: 5 },
  { teamId: 6, leagueId: 3 },
  { teamId: 2, leagueId: 5 },
  { teamId: 3, leagueId: 4 },
  { teamId: 4, leagueId: 2 },
  { teamId: 8, leagueId: 1 },
  { teamId: 10, leagueId: 6 },
  { teamId: 5, leagueId: 1 },
  { teamId: 7, leagueId: 5 },
  { teamId: 9, leagueId: 1 },
  { teamId: 11, leagueId: 2 },
  { teamId: 1, leagueId: 4 },
  { teamId: 13, leagueId: 7 }
]

const winsByTeams = [
  { teamId: 10, wins: 2 },
  { teamId: 6, wins: 4 },
  { teamId: 5, wins: 5 },
  { teamId: 1, wins: 13 },
  { teamId: 7, wins: 3 },
  { teamId: 4, wins: 5 },
  { teamId: 8, wins: 3 },
  { teamId: 2, wins: 7 },
  { teamId: 9, wins: 1 },
  { teamId: 3, wins: 5 },
  { teamId: 11, wins: 1 },
  { teamId: 12, wins: 2 },
  { teamId: 13, wins: 1 }
]

// console.log(getWinsByTeamId(1, winsByTeams));
// console.log(getLeagueIdByIdTeam(5, teamsByLeague));
// console.log(getTeamAllInfo(teams[0], leagues, teamsByLeague, winsByTeams));
// console.log(getAllTeamsInfo(teams, leagues, teamsByLeague, winsByTeams));




/*
  SECCIÓN PROBLEMAS
    - Las siguientes son preguntas básicas de Javascript y manejo de datos. Se evaluará eficiencia, ORDEN y claridad del código entregado.
    - Se debe programar un algoritmo para cada método y que este retorne lo requerido.
    - Debe usar nombres explicativos para sus variables.
    - Usar sintaxis ES6.
    - Puede utilizar funciones auxiliares como apoyo para tener una descomposición de código mas clara al momento de lectura.
    - Su prueba debe ejecutarse sin errores con: node logic-test.js
*/

// 0 Arreglo con los ids de los equipos (función de ejemplo)
function listTeamsIds () {
  return teams.map((client) => client.id)
}

// 1 Arreglo con los nombres de los equipos y el país al que pertenecen, ordenados alfabéticamente por el nombre de su país de origen.
function listTeamsByCountry () {
  // CODE HERE
  return sortJSON(teams,'country','asc');  
  // return sortJSON(getAllTeamsInfo(teams, leagues, teamsByLeague, winsByTeams),'teamCountry','asc');    
}

// 2 Arreglo con los nombres de los equipos ordenados de mayor a menor por la cantidad de victorias en champions league.
function sortTeamsByWins () {
  // CODE HERE
  var resultArray = [];
  var jsonSortedWins = sortJSON(winsByTeams,'wins','desc');
  for (let index = 0; index < jsonSortedWins.length; index++) {
    for (let index2 = 0; index2 < teams.length; index2++) {
      if (jsonSortedWins[index].teamId == teams[index2].id) {
        resultArray.push({idTeam: teams[index2].id, name : teams[index2].name, country : teams[index2].country, wins: jsonSortedWins[index].wins})      
      }      
    } 
  }
  return resultArray;
}

// 3 Arreglo de objetos en donde se muestre el nombre de las ligas y la sumatoria de las victorias de los equipos que pertenecen a ellas.
function leaguesWithWins () {
  // CODE HERE  
  var resultArray = [];  
  for (let index = 0; index < leagues.length; index++) {

    var arrayLeagueTeams = [];
    for (let index2 = 0; index2 < teamsByLeague.length; index2++) {
      if (leagues[index].id == teamsByLeague[index2].leagueId) {
          arrayLeagueTeams.push({idTeam : teamsByLeague[index2].teamId});
      }
    }

    var sumWinsByLeague = 0;
    for (let index3 = 0; index3 < arrayLeagueTeams.length; index3++) {

      var sumWinsTeam = 0;
      for (let index4 = 0; index4 < winsByTeams.length; index4++) {
        if (arrayLeagueTeams[index3].idTeam == winsByTeams[index4].teamId) {
          sumWinsTeam = sumWinsTeam + winsByTeams[index4].wins;
        }
      }
      sumWinsByLeague = sumWinsByLeague +sumWinsTeam;
    }

    resultArray.push({leagueName : leagues[index].name, sumWins : sumWinsByLeague});
  }
  return resultArray;
}

// 4 Objeto en que las claves sean los nombres de las ligas y los valores el nombre del equipo con la menor cantidad de victorias en champions.
function leaguesWithTeamWithLestWins () {
  // CODE HERE
  var resultArray = [];
  for (let index = 0; index < leagues.length; index++) {
    var teamsLeagueIds = getIdTeamsByLeague(leagues[index], teamsByLeague);
    var teamsLeagueArray = [];
    for (let index2 = 0; index2 < teamsLeagueIds.length; index2++) {
      teamsLeagueArray.push(getTeamInfo(teamsLeagueIds[index2], teams, winsByTeams));
    }
    resultArray.push({leagueName : leagues[index].name, teamName : sortJSON(teamsLeagueArray,'wins','asc')[0].name})
  }  
  return resultArray;
}

// 5 Objeto en que las claves sean los nombres de las ligas y los valores el nombre del equipo con la mayor cantidad de victorias en champions.
function leaguesWithTeamWithMostWins () {
  // CODE HERE
  var resultArray = [];
  for (let index = 0; index < leagues.length; index++) {
    var teamsLeagueIds = getIdTeamsByLeague(leagues[index], teamsByLeague);
    var teamsLeagueArray = [];
    for (let index2 = 0; index2 < teamsLeagueIds.length; index2++) {
      teamsLeagueArray.push(getTeamInfo(teamsLeagueIds[index2], teams, winsByTeams));
    }
    resultArray.push({leagueName : leagues[index].name, teamName : sortJSON(teamsLeagueArray,'wins','desc')[0].name})
  }  
  return resultArray;
}

// 6 Arreglo con los nombres de las ligas ordenadas de mayor a menor por la cantidad de victorias de sus equipos.
function sortLeaguesByTeamsByWins () {
  // CODE HERE
  return sortJSON(leaguesWithWins(),'sumWins','desc');
}

// 7 Arreglo con los nombres de las ligas ordenadas de mayor a menor por la cantidad de equipos que participan en ellas.
function sortLeaguesByTeams () {
  // CODE HERE
  var arraySortedTeams = listTeamsByCountry ();
  var resultArray = [];
  for (let index2 = 0; index2 < leagues.length; index2++) {
    var count = 0;
    for (let index = 0; index < arraySortedTeams.length; index++) {
      if (leagues[index2].country == arraySortedTeams[index].country) {
        count++;
      }
    }
    resultArray.push({league : leagues[index2].name, countTeams : count})
  }
  return sortJSON(resultArray,'countTeams','desc');
}

// 8 Agregar un nuevo equipo con datos ficticios a "teams", asociarlo a la liga de Francia y agregar un total de 4 victorias en champions.
// Luego devolver el lugar que ocupa este equipo en el ranking de la pregunta 2.
// No modificar arreglos originales para no alterar las respuestas anteriores al correr la solución
function newTeamRanking () {
  // CODE HERE
  teams.push({ id: 14, country: 'France', name: 'Paris Saint-Germain' });
  teamsByLeague.push({ teamId: 14, leagueId: 7 });
  winsByTeams.push({ teamId: 14, wins: 4 });
  teamsSorted = sortTeamsByWins ();
  // console.log(teamsSorted);  
  for (let index = 0; index < teamsSorted.length; index++) {
    if (teamsSorted[index].idTeam == 14) {
      return index+1;      
    }    
  }
}

var promise = new Promise(function(resolve, reject) {
  for (let index = 0; index < teams.length; index++) {
    teams[index].name = teams[index].name.toUpperCase();    
  }
  resolve(teams);
});

function upperName() {
	return new Promise(function(resolve, reject) {
    for (let index = 0; index < teams.length; index++) {
      teams[index].name = teams[index].name.toUpperCase();    
    }    
    return teams;   
	})
}

var upperName = new Promise (function (resolve, reject) {
  var upperNames = [];
  for (let index = 0; index < teams.length; index++) {
    upperNames[index] = teams[index].name.toUpperCase();    
  }    
  if (upperNames !== null) {
    resolve(upperNames);    
  } else {
    reject('fallo!');
  }
})


// 9 Realice una función que retorne una promesa con los nombres de los equipos en upper case.
// haga la llamada a la función creada desde esta función y asignarle la respuesta a la variable response.
// recuerde que debe esperar el retorno de función asíncrona para que su resultado pueda ser mostrado por el
// console.log. Utilice async await para la llamada asíncrona a la función.
// NOTA: solo debe crear la función asíncrona y agregar la llamada en la siguiente función.
async function getTeamsNamesAsUpperCase () {
  let response
  // ------MAKE AWAIT CALL HERE------
  response  = upperName
    .then (function (params) {
      // console.log(params);
      return params
    })
    .catch (function (error) {
      console.log(error.message);
    })
  // --------------------------------
  console.log('response:');
  console.log(response);
  return response;
}

// Impresión de soluciones. No modificar.
console.log('Pregunta 0')
console.log(listTeamsIds())
console.log('Pregunta 1')
console.log(listTeamsByCountry())
console.log('Pregunta 2')
console.log(sortTeamsByWins())
console.log('Pregunta 3')
console.log(leaguesWithWins())
console.log('Pregunta 4')
console.log((leaguesWithTeamWithLestWins()))
console.log('Pregunta 5')
console.log((leaguesWithTeamWithMostWins()))
console.log('Pregunta 6')
console.log((sortLeaguesByTeamsByWins()))
console.log('Pregunta 7')
console.log((sortLeaguesByTeams()))
console.log('Pregunta 8')
console.log((newTeamRanking()))
console.log('Pregunta 9')
console.log(getTeamsNamesAsUpperCase())
