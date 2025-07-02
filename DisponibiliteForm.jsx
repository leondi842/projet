import React from 'react';
import {
  Box,
  Button,
  Container,
  TextField,
  Typography,
  CssBaseline,
  AppBar,
  Toolbar
} from '@mui/material';

function DisponibiliteForm() {
  return (
    <>
      <CssBaseline />

      {/* Barre de navigation simple */}
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div">
            Recherche de disponibilité
          </Typography>
        </Toolbar>
      </AppBar>

      <Container maxWidth="sm" sx={{ mt: 5 }}>
        {/* Lien vers hôtels annexes */}
        <Box display="flex" justifyContent="flex-start" mb={3}>
          <Button
            variant="contained"
            color="info"
            href="hotels_annexes.php"
          >
            Voir nos hôtels annexes
          </Button>
        </Box>

        {/* Formulaire */}
        <Box
          component="form"
          method="post"
          action="afficher_chambres.php"
          sx={{
            p: 4,
            bgcolor: 'white',
            boxShadow: 3,
            borderRadius: 2,
            mb: 5
          }}
        >
          <Typography variant="h5" mb={3}>
            Rechercher la disponibilité des chambres
          </Typography>

          <TextField
            fullWidth
            label="Date de début"
            name="debut"
            type="date"
            InputLabelProps={{ shrink: true }}
            required
            margin="normal"
          />

          <TextField
            fullWidth
            label="Date de fin"
            name="fin"
            type="date"
            InputLabelProps={{ shrink: true }}
            required
            margin="normal"
          />

          <Button
            type="submit"
            variant="contained"
            color="primary"
            fullWidth
            sx={{ mt: 2 }}
          >
            Vérifier la disponibilité
          </Button>
        </Box>
      </Container>
    </>
  );
}

export default DisponibiliteForm;
