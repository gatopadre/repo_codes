function sortJSON(data, key, orden) {
    return data.sort(function (a, b) {
        var x = a[key],
        y = b[key];

        if (orden === 'asc') {
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        }

        if (orden === 'desc') {
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        }
    });
}

function getAllTeamsInfo(teams, leagues, teamsByLeague, winsByTeams) {
    var arrayResult = [];
    teams.forEach(team => {
        arrayResult.push(getTeamAllInfo(team, leagues, teamsByLeague, winsByTeams));
    });
    return arrayResult;
}

function getTeamAllInfo(team, leagues, teamsByLeague, winsByTeams) {
    var info = {};
    var league = getLeagueById(getLeagueIdByIdTeam(team.id,teamsByLeague).leagueId,leagues);
    var wins = getWinsByTeamId(team.id, winsByTeams);
    info.teamId = team.id;
    info.teamName = team.name;
    info.teamCountry = team.country;
    info.leagueId = league.id;
    info.leagueName = league.name;
    info.leagueCountry = league.country;
    info.wins = wins.wins;
    return info;
}

function getLeagueIdByIdTeam(idTeam, teamsByLeague) {
    return teamsByLeague.find(function(element) {
        if (element.teamId == idTeam) {
            return element;
        }
    });
}

function getLeagueById(idLeague, leagues) {
    return leagues.find(function(league) {
        if (league.id == idLeague) {
            return league;
        }
    });
}

function getWinsByTeamId(idTeam, winsByTeams) {
    return winsByTeams.find(function(element) {
        if (element.teamId == idTeam) {
            return element;
        }
    });
}

function getIdTeamsByLeague(league, teamsByLeague) {
   var arrayResult = [];
   for (let index = 0; index < teamsByLeague.length; index++) {
        if (teamsByLeague[index].leagueId == league.id) {
            arrayResult.push(teamsByLeague[index].teamId);
        }       
   }
   return arrayResult;
}

function getTeamInfo(idTeam, teams, winsByTeams) {
    return teams.find(function(element) {
        if (element.id == idTeam) {
            element.wins = getWinsByTeamId(element.id, winsByTeams).wins;
            return element;
        }
    });
}