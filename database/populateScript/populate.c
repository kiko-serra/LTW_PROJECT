#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

#define DEST "../populate.sql"
#define ADDRESS "address.txt"
#define PHONE "phoneNumbers.txt"
#define NAMES "names.txt"
#define SURNAMES "surnames.txt"
#define BIRTHDAYS "birthdays.txt"
#define WEBSITES_LINKS "websiteLinks.txt"
#define RESTAURANTS_NAMES "restaurantNames.txt"
#define RESTAURANTS_MAILS "emails.txt"
#define WEBSITES_NICKNAMES "nicknames.txt"
#define MAX_USERS 1000
#define MAX_RESTAURANTS 42
#define MAX_ACCOUNTS 419
#define MAX_CLUBS 47
#define M 10000
#define N 100000


int winnerMatchs(int playerW, int playerB)
{
    switch (rand() % 3)
    {
    case 0:
        return playerW;
    case 1:
        return playerB;
    default:
        return -1;
    }
}


void winnersInTournamentsMatchs(int playersInTournament[MAX_USERS_IN_TOURNAMENTS], int users[MAX_USERS],
                                int winner[MAX_USERS_IN_TOURNAMENTS - 1], int playersThatPlayed[MAX_MATCHS][2],
                                int *positionThatPlayed, int tournament_Players[MAX_TOURNAMENTS][MAX_USERS_IN_TOURNAMENTS],
                                int *positionTChessClub, int finalTwinner[MAX_TOURNAMENTS])
{
    int pos = 0;
    participantsInTournaments(playersInTournament, tournament_Players, positionTChessClub);
    for (int i = 0; i < MAX_USERS_IN_TOURNAMENTS; i += 2)
    {
        winner[pos] = winnerMatchsTournament(users[playersInTournament[i]], users[playersInTournament[i + 1]]);
        playersThatPlayed[*positionThatPlayed][0] = users[playersInTournament[i]];
        playersThatPlayed[*positionThatPlayed][1] = users[playersInTournament[i + 1]];
        (*positionThatPlayed)++;
        pos++;
    }
    for (int i = 0; i < MAX_USERS_IN_TOURNAMENTS / 2; i += 2)
    {
        winner[pos] = winnerMatchsTournament(winner[i], winner[i + 1]);
        playersThatPlayed[*positionThatPlayed][0] = winner[i];
        playersThatPlayed[*positionThatPlayed][1] = winner[i + 1];
        (*positionThatPlayed)++;
        pos++;
    }
    winner[pos] = winnerMatchsTournament(winner[4], winner[5]);
    finalTwinner[*positionTChessClub] = winner[pos];
    playersThatPlayed[*positionThatPlayed][0] = winner[4];
    playersThatPlayed[*positionThatPlayed][1] = winner[5];
    (*positionThatPlayed)++;
}

int randomWebsite(int website[MAX_RESTAURANTS])
{
    int aux = rand() % MAX_RESTAURANTS * 2;
    if (aux < MAX_RESTAURANTS)
    {
        return website[aux];
    }

    return -1;
}

char *category()
{
    int aux = rand() % LEVEL_OF_SPONSOR;
    if (aux == GOLD)
    {
        return "GOLD";
    }

    if (aux == SILVER)
    {
        return "SILVER";
    }

    if (aux == BRONZE)
    {
        return "BRONZE";
    }

    return NULL;
}

void swap(int *a, int *b)
{
    int temp = *a;
    *a = *b;
    *b = temp;
}

void randomize(int arr[], int n)
{
    srand(time(NULL));

    for (int i = n - 1; i > 0; i--)
    {
        int j = rand() % (i + 1);
        swap(&arr[i], &arr[j]);
    }
}

void choose_random_unique_number(int *v)
{
    int in, im;

    im = 0;

    for (in = 0; in < N && im < M; ++in)
    {
        int rn = N - in;
        int rm = M - im;
        if (rand() % rn < rm)
            v[im++] = in;
    }

    if (im != M)
    {
        printf("Occorreu um erro no unique number");
    }
}

char *choose_random_word(const char *filename, const int numRand)
{
    FILE *f;
    size_t lineno = 0;
    size_t selectlen;
    char selected[256];
    char current[256];
    selected[0] = '\0';

    if ((f = fopen(filename, "r")) == NULL)
    {
        printf("Error opening file! :(\n");
        return NULL;
    }

    while (fgets(current, sizeof(current), f))
    {
        if (numRand == lineno)
        {
            strcpy(selected, current);
        }
        lineno++;
    }
    fclose(f);

    selectlen = strlen(selected);
    if (selectlen > 0 && selected[selectlen - 1] == '\n')
    {
        selected[selectlen - 1] = '\0';
    }

    return strdup(selected);
}

int main(){
    FILE *dest, *address, *phoneNumber, *names, *links, *emails, *nicknames,
        *sponsors, *sponsorsEmails, *sponsorsAddress, *sponsorsPhone, *clubAddress,
        *clubNames;
    int uniqueId[M];

    srand(time(0));

    if ((address = fopen(ADDRESS, "r")) == NULL)
    {
        printf("Error opening file Address! :(\n");
        return 1;
    }

    if ((phoneNumber = fopen(PHONE, "r")) == NULL)
    {
        printf("Error opening file phone! :(\n");
        return 1;
    }

    if ((names = fopen(RESTAURANTS_NAMES, "r")) == NULL)
    {
        printf("Error opening file website names! :(\n");
        return 1;
    }

    if ((links = fopen(WEBSITES_LINKS, "r")) == NULL)
    {
        printf("Error opening file website links! :(\n");
        return 1;
    }

    if ((nicknames = fopen(WEBSITES_NICKNAMES, "r")) == NULL)
    {
        printf("Error opening file website nicknames! :(\n");
        return 1;
    }

    if ((emails = fopen(RESTAURANTS_MAILS, "r")) == NULL)
    {
        printf("Error opening file website emails! :(\n");
        return 1;
    }

    if ((sponsors = fopen(SPONSOR_NAMES, "r")) == NULL)
    {
        printf("Error opening file sponsor names! :(\n");
        return 1;
    }

    if ((sponsorsEmails = fopen(SPONSOR_EMAILS, "r")) == NULL)
    {
        printf("Error opening file sponsor emails! :(\n");
        return 1;
    }

    if ((sponsorsAddress = fopen(SPONSOR_ADDRESS, "r")) == NULL)
    {
        printf("Error opening file sponsor address! :(\n");
        return 1;
    }

    if ((sponsorsPhone = fopen(SPONSOR_PHONE, "r")) == NULL)
    {
        printf("Error opening file sponsor phone! :(\n");
        return 1;
    }

    if ((clubNames = fopen(CLUB_NAMES, "r")) == NULL)
    {
        printf("Error opening file club names! :(\n");
        return 1;
    }

    if ((clubAddress = fopen(CLUB_ADDRESS, "r")) == NULL)
    {
        printf("Error opening file club adress! :(\n");
        return 1;
    }

    dest = fopen(DEST, "w");

    if (dest == NULL)
    {
        printf("Error!");
        return 1;
    }

    choose_random_unique_number(uniqueId);
    randomize(uniqueId, M);

    char buff[256], buff2[256], buff3[256], buff4[256], dateOfTournament[MAX_TOURNAMENTS][12];
    int aux, aux2 = 0, aux3 = 0, aux4 = 0, users[MAX_USERS], winners[MAX_MATCHS],
             tournaments[MAX_TOURNAMENTS], websites[MAX_RESTAURANTS], accounts[MAX_ACCOUNTS],
             matches[MAX_MATCHS], sponsor[MAX_SPONSORS], club[MAX_CLUBS],
             playerSponsor[MAX_SPONSORS], tournamentSponsor[MAX_SPONSORS],
             playersInTournament[MAX_USERS_IN_TOURNAMENTS], winnersInTournaments[MAX_USERS_IN_TOURNAMENTS - 1],
             playerW, playerB, playersThatPlayed[MAX_MATCHS][2], positionThatPlayed = 0,
             matchChessClub[MAX_MATCHS][2], tournament_Players[MAX_TOURNAMENTS][MAX_USERS_IN_TOURNAMENTS],
             positionTChessClub = 0, tournamentChessClub[MAX_TOURNAMENTS][MAX_USERS_IN_TOURNAMENTS], finalTwinner[MAX_TOURNAMENTS];

    // TABELA PLAYER
    fprintf(dest, "PRAGMA foreign_keys = on;\nBEGIN TRANSACTION;\n\n------------------------------------------------------TABLE PLAYER-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_USERS; i++)
    {
        fgets(buff, 255, (FILE *)address);
        buff[strlen(buff) - 1] = '\0';
        fgets(buff2, 16, (FILE *)phoneNumber);
        buff2[strlen(buff2) - 1] = '\0';
        fprintf(dest, "INSERT INTO Player VALUES (%d,\"%s\",\"%s\",\"%s\",\"%s\",'%s');\n",
                uniqueId[i], choose_random_word(NAMES, rand() % 1000), choose_random_word(SURNAMES, rand() % 1000), buff, buff2,
                choose_random_word(BIRTHDAYS, rand() % 1000));
        users[i] = uniqueId[i];
    }

    // TABELA FIDE_RANKING
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE FIDE_RANKING-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_USERS; i++)
    {
        aux2 = rand() % 4;
        switch (aux2)
        {
        case 0:
            strcpy(buff, "MEN");
            break;
        case 1:
            strcpy(buff, "WOMEN");
            break;
        case 2:
            strcpy(buff, "JUNIORS");
            break;
        case 3:
            strcpy(buff, "GIRLS");
            break;
        }

        aux = rand() % 3000;
        if (aux > 2400)
        {
            fprintf(dest, "INSERT INTO FideRanking VALUES (%d,%d,\"%s\",\"%s\",%d);\n",
                    users[i], users[i], buff, "Grandmaster (GM)", aux);
        }
        else if (aux > 2300)
        {
            fprintf(dest, "INSERT INTO FideRanking VALUES (%d,%d,\"%s\",\"%s\",%d);\n",
                    users[i], users[i], buff, "International Master (IM)", aux);
        }
        else if (aux > 2200)
        {
            fprintf(dest, "INSERT INTO FideRanking VALUES (%d,%d,\"%s\",\"%s\",%d);\n",
                    users[i], users[i], buff, "FIDE Master (FM)", aux);
        }
        else if (aux > 2000)
        {
            fprintf(dest, "INSERT INTO FideRanking VALUES (%d,%d,\"%s\",\"%s\",%d);\n",
                    users[i], users[i], buff, "Candidate Master (CM)", aux);
        }
        else
        {
            fprintf(dest, "INSERT INTO FideRanking VALUES (%d,%d,\"%s\",%s,%d);\n",
                    users[i], users[i], buff, "NULL", aux);
        }
    }

    // TABELA WEBSITE
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE WEBSITE-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_RESTAURANTS; i++)
    {
        fgets(buff, 255, (FILE *)links);
        buff[strlen(buff) - 1] = '\0';
        fgets(buff2, 50, (FILE *)names);
        buff2[strlen(buff2) - 1] = '\0';
        fprintf(dest, "INSERT INTO Website VALUES (%d,\"%s\",\"%s\");\n",
                uniqueId[i + MAX_USERS], buff, buff2);
        websites[i] = uniqueId[i + MAX_USERS];
    }

    // TABELA ACCOUNT
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE ACCOUNT-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_ACCOUNTS; i++)
    {
        fgets(buff, 30, (FILE *)nicknames);
        buff[strlen(buff) - 1] = '\0';
        fgets(buff2, 255, (FILE *)emails);
        buff2[strlen(buff2) - 1] = '\0';
        aux = rand() % 3000;
        if (aux > 2400)
        {
            fprintf(dest, "INSERT INTO Account VALUES (%d,\"%s\",\"%s\",\"%s\",%d,%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS], buff, buff2, "Grandmaster (GM)", aux, websites[rand() % MAX_RESTAURANTS], users[i]);
        }
        else if (aux > 2300)
        {
            fprintf(dest, "INSERT INTO Account VALUES (%d,\"%s\",\"%s\",\"%s\",%d,%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS], buff, buff2, "International Master (IM)", aux, websites[rand() % MAX_RESTAURANTS], users[i]);
        }
        else if (aux > 2200)
        {
            fprintf(dest, "INSERT INTO Account VALUES (%d,\"%s\",\"%s\",\"%s\",%d,%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS], buff, buff2, "FIDE Master (FM)", aux, websites[rand() % MAX_RESTAURANTS], users[i]);
        }
        else if (aux > 2000)
        {
            fprintf(dest, "INSERT INTO Account VALUES (%d,\"%s\",\"%s\",\"%s\",%d,%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS], buff, buff2, "Candidate Master (CM)", aux, websites[rand() % MAX_RESTAURANTS], users[i]);
        }
        else
        {
            fprintf(dest, "INSERT INTO Account VALUES (%d,\"%s\",\"%s\",%s,%d,%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS], buff, buff2, "NULL", aux, websites[rand() % MAX_RESTAURANTS], users[i]);
        }

        accounts[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS];
    }

    // TABELA TOURNAMENT
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE TOURNAMENT-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_TOURNAMENTS; i++)
    {
        char *dateAux = choose_random_word(MATCH_DATE, rand() % 1000);
        fprintf(dest, "INSERT INTO Tournament VALUES (%d,'%s','%s',\"%s\",%s);\n",
                uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS], dateAux, dateAux,
                strcat(choose_random_word(NAMES, rand() % 1000), " Tournament"), "NULL");
        tournaments[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS];
        strcpy(dateOfTournament[i], dateAux);
    }

    // TABELA MATCH
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE MATCH-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_MATCHS - ((MAX_USERS_IN_TOURNAMENTS - 1) * MAX_TOURNAMENTS); i++)
    {
        do
        {
            playerW = users[rand() % MAX_USERS];
            playerB = users[rand() % MAX_USERS];
        } while (playerW == playerB);
        winners[i] = winnerMatchs(playerW, playerB);
        playersThatPlayed[i][0] = playerW;
        playersThatPlayed[i][1] = playerB;
        aux2 = randomWebsite(websites);
        aux3 = rand() % 120 + 10;
        strcpy(buff, choose_random_word(MATCH_DURATION, rand() % 12));
        if (strcmp(buff, "2:00:00") == 0 || strcmp(buff, "1:00:00") == 0)
        {
            strcpy(buff2, "CLASSIC");
        }
        else if (strcmp(buff, "0:30:00") == 0 || strcmp(buff, "0:15:00") == 0 || strcmp(buff, "0:10:00") == 0)
        {
            strcpy(buff2, "RAPID");
        }
        else if (strcmp(buff, "0:03:00") == 0 || strcmp(buff, "0:05:00") == 0)
        {
            strcpy(buff2, "BLITZ");
        }
        else
        {
            strcpy(buff2, "BULLET");
        }
        if (aux2 == -1)
        {
            if (winners[i] != -1)
            {
                fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s%d\",'%s','%s','%s',%d,%d,\"%s\",%s,%s);\n",
                        uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                        "Win at move ", aux3, choose_random_word(MATCH_DATE, rand() % 1000),
                        buff, buff, rand() % 30, aux3, buff2, "NULL", "NULL");
            }
            else
            {
                switch (rand() % 3)
                {
                case 0:
                    fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s\",'%s','%s','%s',%d,%d,\"%s\",%s,%s);\n",
                            uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                            "Stalemate", choose_random_word(MATCH_DATE, rand() % 1000),
                            buff, buff, rand() % 30, aux3, buff2, "NULL", "NULL");
                    break;

                default:
                    fprintf(dest, "INSERT INTO Match VALUES (%d,%s,'%s','%s','%s',%d,%d,\"%s\",%s,%s);\n",
                            uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                            "NULL", choose_random_word(MATCH_DATE, rand() % 1000),
                            buff, buff, rand() % 30, aux3, buff2, "NULL", "NULL");
                    break;
                }
            }
        }
        else
        {
            if (winners[i] != -1)
            {
                fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s%d\",'%s','%s','%s',%d,%d,\"%s\",%s,%d);\n",
                        uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                        "Win at move ", aux3, choose_random_word(MATCH_DATE, rand() % 1000),
                        buff, buff, rand() % 30, aux3, buff2, "NULL", aux2);
            }
            else
            {
                switch (rand() % 3)
                {
                case 0:
                    fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s\",'%s','%s','%s',%d,%d,\"%s\",%s,%d);\n",
                            uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                            "Stalemate", choose_random_word(MATCH_DATE, rand() % 1000),
                            buff, buff, rand() % 30, aux3, buff2, "NULL", aux2);
                    break;

                default:
                    fprintf(dest, "INSERT INTO Match VALUES (%d,%s,'%s','%s','%s',%d,%d,\"%s\",%s,%d);\n",
                            uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                            "NULL", choose_random_word(MATCH_DATE, rand() % 1000),
                            buff, buff, rand() % 30, aux3, buff2, "NULL", aux2);
                    break;
                }
            }
        }

        matches[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS];
    }

    positionThatPlayed = MAX_MATCHS - ((MAX_USERS_IN_TOURNAMENTS - 1) * MAX_TOURNAMENTS);

    winnersInTournamentsMatchs(playersInTournament, users, winnersInTournaments, playersThatPlayed,
                               &positionThatPlayed, tournament_Players, &positionTChessClub, finalTwinner);
    aux = 0;
    aux2 = randomWebsite(websites);
    aux3 = 0;
    strcpy(buff, choose_random_word(MATCH_DURATION, rand() % 12));
    if (strcmp(buff, "2:00:00") == 0 || strcmp(buff, "1:00:00") == 0)
    {
        strcpy(buff2, "CLASSIC");
    }
    else if (strcmp(buff, "0:30:00") == 0 || strcmp(buff, "0:15:00") == 0 || strcmp(buff, "0:10:00") == 0)
    {
        strcpy(buff2, "RAPID");
    }
    else if (strcmp(buff, "0:03:00") == 0 || strcmp(buff, "0:05:00") == 0)
    {
        strcpy(buff2, "BLITZ");
    }
    else
    {
        strcpy(buff2, "BULLET");
    }
    for (int i = MAX_MATCHS - ((MAX_USERS_IN_TOURNAMENTS - 1) * MAX_TOURNAMENTS); i < MAX_MATCHS; i++)
    {
        aux4 = rand() % 120 + 10;

        if (aux2 == -1)
        {
            fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s%d\",'%s','%s','%s',%d,%d,\"%s\",%d,%s);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS],
                    "Win at move ", aux4, dateOfTournament[aux3], buff, buff, rand() % 30, aux4, buff2,
                    tournaments[aux3], "NULL");
        }
        else
        {
            fprintf(dest, "INSERT INTO Match VALUES (%d,\"%s%d\",'%s','%s','%s',%d,%d,\"%s\",%d,%d);\n",
                    uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS], "Win at move ", aux4,
                    dateOfTournament[aux3], buff, buff, rand() % 30, aux4, buff2, tournaments[aux3], aux2);
        }
        matches[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS];
        winners[i] = winnersInTournaments[aux];
        aux++;
        if (aux == MAX_USERS_IN_TOURNAMENTS - 1)
        {
            if (aux2 != -1)
            {
                fprintf(dest, "UPDATE Tournament SET id_website = %d WHERE id_tournament = %d;\n",
                        aux2, tournaments[aux3]);
            }

            strcpy(buff, choose_random_word(MATCH_DURATION, rand() % 12));
            if (strcmp(buff, "2:00:00") == 0 || strcmp(buff, "1:00:00") == 0)
            {
                strcpy(buff2, "CLASSIC");
            }
            else if (strcmp(buff, "0:30:00") == 0 || strcmp(buff, "0:15:00") == 0 || strcmp(buff, "0:10:00") == 0)
            {
                strcpy(buff2, "RAPID");
            }
            else if (strcmp(buff, "0:03:00") == 0 || strcmp(buff, "0:05:00") == 0)
            {
                strcpy(buff2, "BLITZ");
            }
            else
            {
                strcpy(buff2, "BULLET");
            }

            aux3++;
            positionTChessClub++;
            if (aux3 == MAX_TOURNAMENTS)
            {
                break;
            }
            winnersInTournamentsMatchs(playersInTournament, users, winnersInTournaments, playersThatPlayed, &positionThatPlayed, tournament_Players, &positionTChessClub, finalTwinner);
            aux = 0;
            aux2 = randomWebsite(websites);
        }
    }

    // TABELA SPONSOR
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE SPONSOR-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_SPONSORS; i++)
    {
        fgets(buff, 255, (FILE *)sponsors);
        buff[strlen(buff) - 1] = '\0';
        fgets(buff2, 16, (FILE *)sponsorsPhone);
        buff2[strlen(buff2) - 1] = '\0';
        fgets(buff3, 255, (FILE *)sponsorsEmails);
        buff3[strlen(buff3) - 1] = '\0';
        fgets(buff4, 255, (FILE *)sponsorsAddress);
        buff4[strlen(buff4) - 1] = '\0';
        fprintf(dest, "INSERT INTO Sponsor VALUES (%d,\"%s\",\"%s\",\"%s\",\"%s\");\n",
                uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS + MAX_MATCHS],
                buff, buff2, buff3, buff4);
        sponsor[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS + MAX_MATCHS];
    }

    // TABELA PLAYER_MATCH
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE PLAYER_MATCH-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_MATCHS; i++)
    {
        if (winners[i] == playersThatPlayed[i][0])
        {
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][0], matches[i], 1);
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][1], matches[i], 0);
        }
        else if (winners[i] == playersThatPlayed[i][1])
        {
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][0], matches[i], 0);
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][1], matches[i], 1);
        }
        else
        {
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][0], matches[i], 0);
            fprintf(dest, "INSERT INTO PlayerMatch VALUES (%d,%d,%d);\n",
                    playersThatPlayed[i][1], matches[i], 0);
        }
        matchChessClub[i][0] = playersThatPlayed[i][0];
        matchChessClub[i][1] = playersThatPlayed[i][1];
    }

    // TABELA PLAYER_TOURNAMENT
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE PLAYER_TOURNAMENT-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_TOURNAMENTS; i++)
    {
        for (int j = 0; j < MAX_USERS_IN_TOURNAMENTS; j++)
        {
            if (users[tournament_Players[i][j]] == finalTwinner[i])
            {
                fprintf(dest, "INSERT INTO PlayerTournament VALUES (%d,%d,%d);\n",
                        users[tournament_Players[i][j]], tournaments[i], 1);
            }
            else
            {
                fprintf(dest, "INSERT INTO PlayerTournament VALUES (%d,%d,%d);\n",
                        users[tournament_Players[i][j]], tournaments[i], 0);
            }

            tournamentChessClub[i][j] = users[tournament_Players[i][j]];
        }
    }

    // TABELA CHESS_CLUB
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE CHESS_CLUB-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_CLUBS; i++)
    {
        fgets(buff, 255, (FILE *)clubNames);
        buff[strlen(buff) - 1] = '\0';
        fgets(buff2, 255, (FILE *)clubAddress);
        buff2[strlen(buff2) - 1] = '\0';
        fprintf(dest, "INSERT INTO ChessClub VALUES (%d,\"%s\",\"%s\",%d,%d);\n",
                uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS + MAX_MATCHS + MAX_SPONSORS],
                buff, buff2, rand() % 3000, 0);
        club[i] = uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS + MAX_MATCHS + MAX_SPONSORS];
    }

    // TABELA MEMBER_ID
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE MEMBER_ID-------------------------------------------------------\n\n");
    aux = 0;
    aux2 = 0;
    int numOfMembers[MAX_CLUBS];
    for (int i = 0; i < MAX_CLUBS - 1; i++)
    {
        numOfMembers[i] = rand() % 30 + 3;
    }
    numOfMembers[MAX_CLUBS - 1] = MAX_USERS;
    for (int i = 0; i < MAX_USERS; i++)
    {
        fprintf(dest, "INSERT INTO MemberId VALUES (%d,%d,%d);\n",
                club[aux], users[i],
                uniqueId[i + MAX_USERS + MAX_RESTAURANTS + MAX_ACCOUNTS + MAX_TOURNAMENTS + MAX_MATCHS + MAX_SPONSORS + MAX_CLUBS]);
        for (int j = 0; j < MAX_USERS; j++)
        {
            if (matchChessClub[j][0] == users[i])
            {
                matchChessClub[j][0] = club[aux];
            }

            if (matchChessClub[j][1] == users[i])
            {
                matchChessClub[j][1] = club[aux];
            }
        }

        for (int j = 0; j < MAX_TOURNAMENTS; j++)
        {
            for (int k = 0; k < MAX_USERS_IN_TOURNAMENTS; k++)
            {
                if (tournamentChessClub[j][k] == users[i])
                {
                    tournamentChessClub[j][k] = club[aux];
                }
            }
        }
        if (numOfMembers[aux] <= aux2)
        {
            aux2 = 0;
            aux++;
        }
        aux2++;
    }

    // TABELA LEVEL_OF_SPONSOR_PLAYER
    aux2 = 0;
    aux3 = 0;
    for (int i = 0; i < MAX_SPONSORS; i++)
    {
        aux = rand() % 3;
        switch (aux)
        {
        case 0:
            playerSponsor[i] = 1;
            break;
        case 1:
            aux2++;
            playerSponsor[i] = 1;
            if (aux2 >= MAX_USERS)
            {
                aux3 = 1;
                break;
            }
            playerSponsor[i] = 2;
            break;
        case 2:
            aux2++;
            playerSponsor[i] = 1;
            if (aux2 >= MAX_USERS)
            {
                aux3 = 1;
                break;
            }
            aux2++;
            playerSponsor[i] = 2;
            if (aux2 >= MAX_USERS)
            {
                aux3 = 1;
                break;
            }
            playerSponsor[i] = 3;
            break;
        }
        if (aux3 == 1)
        {
            break;
        }
    }

    fprintf(dest, "\n\n\n------------------------------------------------------TABLE LEVEL_OF_SPONSOR_PLAYER-------------------------------------------------------\n\n");
    aux2 = 0;
    for (int i = 0; i < MAX_SPONSORS; i++)
    {
        switch (playerSponsor[i])
        {
        case 1:
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            break;
        case 2:
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            break;
        case 3:
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorPlayer VALUES (%d,%d,\"%s\");\n",
                    users[aux2], sponsor[i], category());
            break;
        }
    }

    // TABELA LEVEL_OF_SPONSOR_TOURNAMENT
    aux2 = 0;
    aux3 = 0;
    for (int i = 0; i < MAX_SPONSORS; i++)
    {
        aux = rand() % 3;
        switch (aux)
        {
        case 0:
            tournamentSponsor[i] = 1;
            break;
        case 1:
            aux2++;
            tournamentSponsor[i] = 1;
            if (aux2 >= MAX_TOURNAMENTS)
            {
                aux3 = 1;
                break;
            }
            tournamentSponsor[i] = 2;
            break;
        case 2:
            aux2++;
            tournamentSponsor[i] = 1;
            if (aux2 >= MAX_TOURNAMENTS)
            {
                aux3 = 1;
                break;
            }
            aux2++;
            tournamentSponsor[i] = 2;
            if (aux2 >= MAX_TOURNAMENTS)
            {
                aux3 = 1;
                break;
            }
            tournamentSponsor[i] = 3;
            break;
        }
        if (aux3 == 1)
        {
            break;
        }
    }

    fprintf(dest, "\n\n\n------------------------------------------------------TABLE LEVEL_OF_SPONSOR_TOURNAMENT-------------------------------------------------------\n\n");
    aux2 = 0;
    for (int i = 0; i < MAX_SPONSORS; i++)
    {
        switch (tournamentSponsor[i])
        {
        case 1:
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            break;
        case 2:
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            break;
        case 3:
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            aux2++;
            fprintf(dest, "INSERT INTO LevelOfSponsorTournament VALUES (%d,%d,\"%s\");\n",
                    tournaments[aux2], sponsor[i], category());
            break;
        }
    }

    // TABELA MATCH_CHESS_CLUB
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE MATCH_CHESS_CLUB-------------------------------------------------------\n\n");
    for (int i = 0; i < MAX_MATCHS; i++)
    {
        if (matchChessClub[i][0] != matchChessClub[i][1])
        {
            fprintf(dest, "INSERT INTO MatchChessClub VALUES (%d,%d);\n",
                    matches[i], matchChessClub[i][0]);
        }
        fprintf(dest, "INSERT INTO MatchChessClub VALUES (%d,%d);\n",
                matches[i], matchChessClub[i][1]);
    }

    // TABELA TOURNAMENT_CHESS_CLUB
    fprintf(dest, "\n\n\n------------------------------------------------------TABLE TOURNAMENT_CHESS_CLUB-------------------------------------------------------\n\n");
    aux = 1;
    for (int i = 0; i < MAX_TOURNAMENTS; i++)
    {
        for (int j = 0; j < MAX_USERS_IN_TOURNAMENTS; j++)
        {
            for (int k = j + 1; k < MAX_USERS_IN_TOURNAMENTS; k++)
            {
                if (tournamentChessClub[i][j] == tournamentChessClub[i][k])
                {
                    aux = 0;
                    break;
                }
            }

            if (aux == 1)
            {
                fprintf(dest, "INSERT INTO TournamentChessClub VALUES (%d,%d);\n",
                        tournaments[i], tournamentChessClub[i][j]);
            }
            aux = 1;
        }
    }

    fprintf(dest, "\nCOMMIT TRANSACTION;");

    fclose(clubNames);
    fclose(clubAddress);
    fclose(sponsors);
    fclose(sponsorsAddress);
    fclose(sponsorsPhone);
    fclose(sponsorsEmails);
    fclose(names);
    fclose(links);
    fclose(nicknames);
    fclose(emails);
    fclose(address);
    fclose(phoneNumber);
    fclose(dest);

    return 0;
}